<?php

require_once("models/config.php");
require_once("stripe/init.php");
require_once("db/connect.php");
require_once('stripe/init.php');

require_once("models/header.php");

if (!$loggedInUser) {
        header('Location: login.php');
}


// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_e0ZOwmIiZzNMMeUI2tkUpcy0");

if (!empty($_POST)) {
  // Get the credit card details submitted by the form
  $token = $_POST['stripeToken'];
  //echo "We got the token $token";

  // Create the charge on Stripe's servers - this will charge the user's card
  try {
    $charge = \Stripe\Charge::create(array(
      "amount" => $_POST['amount'], // amount in cents, again
      "currency" => "USD",
      "source" => $token,
      "description" => $_POST['class_name'] . ' - ' . $_POST['session']
      ));
  } catch(\Stripe\Error\Card $e) {
    // The card has been declined
	echo false;
	error_log("card denied");
	die();
  }

	//print_r($_POST);
	
	/* SQL - decrement session seats */
	$stmt = $mysqli_piq->prepare("update session set seats = seats - 1 where id = ?");
	$stmt->bind_param('i', $_POST['session_id']);
	$result = $stmt->execute();
	if (!$result) {
		error_log("could not decrement seats for session id " . $_POST['session_id']);
		echo false;

	} else {
		error_log("successfully charged card");

		/* SQL - add session for user after paying */
		$stmt = $mysqli_piq->prepare("insert into request (status, user_id, session_id, class_id, class_name, chef_id) values('approved', ?, ?, ?, ?, ?)");
		$stmt->bind_param("iiisi", $loggedInUser->user_id, $_POST['session_id'], $_POST['class_id'], $_POST['class_name'], $_POST['chef_id']);
		$stmt->execute();

		echo true;
	}

	die();
}

if (!($stmt = $mysqli_piq->prepare("
select * from class where id = ?
"))) {
	echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
}

if (!$stmt->bind_param("i", $_GET['id'])) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->store_result();
$stmt->bind_result($name, $description, $image, $price, $user_id, $address, $intersection, $class_id, $request_form);
$stmt->fetch();

$stmt->close();

if (!($stmt = $mysqli_piq->prepare("
	select seats, `date`, `repeat`, id from `session` where `class_id` = ?
"))) {
	echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
}

if (!$stmt->bind_param("i", $_GET['id'])) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

$stmt->bind_result($seats, $date, $repeat, $id);

$sessions = [];
while($stmt->fetch()) {
	$sessions[] = array('seats' => $seats, 'date' => $date, 'repeat' => $repeat, 'id' => $id);
}

$stmt->close();

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= $name; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
				<script>(function(){var qs,js,q,s,d=document,gi=d.getElementById,ce=d.createElement,gt=d.getElementsByTagName,id='typef_orm',b='https://s3-eu-west-1.amazonaws.com/share.typeform.com/';if(!gi.call(d,id)){js=ce.call(d,'script');js.id=id;js.src=b+'share.js';q=gt.call(d,'script')[0];q.parentNode.insertBefore(js,q)}id=id+'_';if(!gi.call(d,id)){qs=ce.call(d,'link');qs.rel='stylesheet';qs.id=id;qs.href=b+'share-button.css';s=gt.call(d,'head')[0];s.appendChild(qs,s)}})()</script>
        <script src="//load.sumome.com/" data-sumo-site-id="5e445f80d3e8e136270db5056c7a69fd73be6ee2dc7d167cd25ad34e2dc09fe1" async="async"></script>
  </head>
    <body style='margin-top: 40px;'>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=377900289009078";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class='row center-row'>
            <!--header-->
            <div class='col-md-12'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
			 				  <?php // include_once('piqpass_nav.php'); ?>
								<div class='col-md-10' align='left' style='margin-top: 20px;'>
									<div align='left' class="fb-like" data-href="https://www.facebook.com/trypiq" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
								</div>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px;'>
                  <div class='col-md-9'>
											<div class='col-md-11 bg-warning' style='margin-top: 25px; padding-top: 10px;'>
												<p><Strong>What is Piq?</strong><br />
													Piq is a social marketplace where professional chefs and hobbyists can design and promote their classes. We believe that no person can make the same food the same, and that there's a story behind the cooking of each person. We hope to provide more affordable options for those interested learning about the people of Toronto through the dishes they discover. Beyond the restaurants, we think there's a trove of culinary gems in the city waiting to be uncovered.</p>
											</div>
											<div class='col-md-12 header header-large' style='margin-left: -15px; margin-top: 40px;'><?= $name ?></div>
											<div class='col-md-11' style='margin-top: 30px; height: 400px; background-image: url("img/<?= $image ?>"); background-position: center; background-size: cover;'>&nbsp;</div>
                      <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'>
											<p>
												<?= $description ?>
											</p>
											</div>
                      <div class="fb-comments col-md-12" style='margin-left: -15px; margin-top: 30px;' data-width="100%" data-href="http://trypiq.com/class.php?id=<?php echo $class_id;?>" data-numposts="5"></div>
                      <!--maps-->
                      <!--
											<div class='col-md-12' style='margin-left: -15px; margin-top: 20px;'><span class='header header-large'>Map</span></div>
                      <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'><p class='bg-warning' align='center' style='padding-top: 15px; padding-bottom: 15px;'><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> The exact address of the class will be emailed to you once your request is accepted by Colin.</p></span></div>

                      <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2885.2783807043675!2d-79.30235888518642!3d43.683975658459296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cc1a1f985ddf%3A0x6be02d40c4bdd655!2sUpper+Beaches%2C+Toronto%2C+ON!5e0!3m2!1sen!2sca!4v1460762987826" width='100%' height="250" frameborder="0" style="border:0" allowfullscreen></iframe></span></div>
										-->
                </div>
                <div class='col-md-3' style='margin-left: -15px;'>
                  <div class='col-md-12' style='margin-left: -15px; margin-top: 43px; margin-bottom: 20px;'>
                    <center><span class='price'>$<?= $price ?> / Person</span></center>
                  </div>
                  <div class='col-md-12 bg-warning' style='margin-left: -15px; margin-top: 10px; margin-bottom: 20px;'>
                    <p><center><span class='small'>This class fee of $<?= $price ?> include the cost of ingredients, materials provided by the instructor, clean-up fee, any refreshments provided, and the instructor's time spent acquiring the ingredients and teaching the class.</span></center></p>
									</div>
		<form method='post' name='select_session' action='<?= $_SERVER['PHP_SELF'] ?>' id='select_session'>
			<input type='hidden' name='class_id' value='<?= $class_id ?>'>
			<input type='hidden' name='chef_id' value='<?= $user_id ?>'>
			<input type='hidden' name='class_name' value='<?= $name ?>'>
<!--
		<div class='col-md-12' style='margin-left: -15px;'>
			<div class="form-row">
                		<label>Card Number</label>
				<input type="text" size="20" autocomplete="off" class="card-number" />
			</div>
			<div class="form-row">
				<label>CVC</label>
				<input type="text" size="4" autocomplete="off" class="card-cvc" />
			</div>
			<div class="form-row">
				<label>Expiration (MM/YYYY)</label>
				<input type="text" size="2" class="card-expiry-month"/>
				<span> / </span>
				<input type="text" size="4" class="card-expiry-year"/>
			</div>
		</div>
-->
                  <div class='col-md-12' style='margin-left: -15px;'>
                    <select name='session' class="form-control" id='sessions_select'>
                      <option>Select Time</option>
			<?php
				foreach ($sessions as $session) {
					if ($session['seats'] > 0) {
						$session_time = strtotime($session['date']);
						$day = date('l, F jS', $session_time);
			?>
						<option value='<?= $session['id'] ?>'>(<?= $session['seats'] . " Slots) " . date('G:iA', $session_time) . " - " . $day; ?></option>
			<?php
					}
				}

			 ?>
                    </select>
                  </div>

                  <div class='col-md-12' style='margin-top: 10px; margin-left: -15px;'>
                    <center>
			                     <a id='bookButton' class='btn btn-lg btn-success' href='<?= $request_form ?>' onClick="_gaq.push(['_trackEvent', 'Book Now', 'click', '<?= $name ?>', '0']);" target='_blank'><strong>Book Now</strong></a><!--</button>-->
                    </center>
                  </div>

                  <div class='col-md-12' style='margin-left: -15px; margin-top: 50px;'>
                    <p class='small'><strong>Refund Policy:</strong> Piq offers full refunds as long the order is canceled 3 days before the class. We also offer a 50% discount if you request a refund the day of the class. All students will be refunded 100% of the class fees if the chef cancels the class at any time.</p>
                    <p class='small'><strong>Payment Methods:</strong> All Canadian users can use Visa, MasterCard, and American Express. U.S. consumers can use Visa, MasterCard, American Express, JCB, Discover, and Diners Club.</p>
                    <p class='small'><strong>Securing Payments</strong><br />
                    All payments on Piq is processed using Stripe - a highly secure payment processor. Piq does not store any credit card information.</p>
                  </div>
                  <div class='col-md-12' style='margin-top: 10px; margin-left: -15px;'>
                    <center>
			                     <a class='btn btn-sm btn-default' href='https://travis47.typeform.com/to/pULTZo' target='_blank'><strong>Contact Us</strong></a><!--</button>-->
                    </center>
                  </div>
		</form>
									<div class='col-md-12 neg-15' style='margin-top: 20px;'>
										<div class="fb-page" data-href="https://www.facebook.com/trypiq/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" style='margin-top: 40px;'><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/trypiq/"><a href="https://www.facebook.com/trypiq/">Piq - Toronto Cooking Classes</a></blockquote></div></div>
									</div>
                </div>
            </div>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
				<script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-76836253-1','auto');ga('send','pageview');
        </script>

	<script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>

	<script src="https://checkout.stripe.com/checkout.js"></script>

	<script>
	  var handler = StripeCheckout.configure({
	    key: 'pk_test_5Ir0zjoUeZUgOHIWP4WRYVid',
	    image: 'img/stripe_logo.jpg',
	    locale: 'auto',
	    name: '<?= $name ?>',
	    description: '<?=  date('G:iA', $session_time) . " - " . $day ?>',
	    amount: '<?= $price * 100 ?>',
	    currency: "USD",
	    token: function(token) {
	      //console.log("token is " + token.id)
			$.post(
				'<?= $_SERVER['PHP_SELF'] ?>',
				{
					'stripeToken': token.id,
					'amount': <?= $price * 100 ?>,
					'class_name': '<?= $name ?>',
					'class_id': '<?= $class_id ?>',
					'chef_id': '<?= $user_id ?>',
					'session': $('#sessions_select').find(":selected").text(),
					'session_id': $('#sessions_select').find(":selected").val()
				},
				function(data) {
					//$( ".result" ).html( data );
					console.log(data);
					if (data) {
						window.location = 'dashboard.php';
					}
				}
			);
		}
	});

	  $('#bookButton').on('click', function(e) {
	    // Open Checkout with further options:
		if ($('#sessions_select').find(":selected").text() == 'Select Time') {
			alert('Please select a session.');
		} else {
			handler.open({});
		}
	    	e.preventDefault();
	  });

	  // Close Checkout on page navigation:
	  // $(window).on('popstate', function() {
	  //   handler.close();
	  // });
	</script>

    </body>
</html>
