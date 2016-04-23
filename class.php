<?php

require_once("models/config.php");
require_once("stripe/init.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

require_once("db/connect.php");
/*
if (!empty($_POST)) {

	Stripe::setApiKey("sk_test_e0ZOwmIiZzNMMeUI2tkUpcy0");
	$error = '';
	$success = '';
	try {
		if (!isset($_POST['stripeToken'])) {
			throw new Exception("The Stripe Token was not generated correctly");
		}

		Stripe_Charge::create(array("amount" => 1000,
					"currency" => "usd",
					"card" => $_POST['stripeToken']));
		$success = 'Your payment was successful.';

		if(!($newRequestState = $mysqli_piq->query("
			insert into request (status, chef_id, user_id, session_id, class_id, username, class_name) values('pending', " . $_POST['chef_id'] . ", " . $loggedInUser->user_id . ", " . $_POST['session'] . ", " . $_POST['class_id'] . ", '" . $loggedInUser->displayname . "', '" . $_POST['class_name'] . "')"))) {
			echo "Could not insert into request <br/>" . $newRequestState->error;
		} else {
			header('Location: dashboard.php');
		}
		$newRequestState->close();
		echo $success;

	}
	catch (Exception $e) {
		$error = $e->getMessage();
		echo $error;
	}
}
*/

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
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/sean.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <style>
        .header {font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .price {font-family: 'Open Sans', sans-serif; font-weight: 300; font-size: 25px;}
        .header-large {font-size: 25px;}
        p {line-height: 1.7em; font-size: 15px; color: #333; }
        .request {background-color: #fc6472; padding-top: 8px; padding-bottom: 8px; font-size: 18px; color: #fff;font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .small {font-size: 12px !important;}
        </style>
				<script>(function(){var qs,js,q,s,d=document,gi=d.getElementById,ce=d.createElement,gt=d.getElementsByTagName,id='typef_orm',b='https://s3-eu-west-1.amazonaws.com/share.typeform.com/';if(!gi.call(d,id)){js=ce.call(d,'script');js.id=id;js.src=b+'share.js';q=gt.call(d,'script')[0];q.parentNode.insertBefore(js,q)}id=id+'_';if(!gi.call(d,id)){qs=ce.call(d,'link');qs.rel='stylesheet';qs.id=id;qs.href=b+'share-button.css';s=gt.call(d,'head')[0];s.appendChild(qs,s)}})()</script>

    </head>
    <body style='margin-top: 40px;'>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class='row' style='width: 80%; margin: 0 auto;'>
            <!--header-->
            <div class='col-md-12'>
                <div class='col-md-2' style='margin-left: -15px;'><img src='img/piqlanding1.jpg' /></div>
                <div class='col-md-10' style='margin-top: 15px; margin-left: -15px;'>
                  <p align='right'>
			 <?= include_once('piqpass_nav.php'); ?>
                </p>
                </div>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px;'>
                  <div class='col-md-9' style='margin-left: -15px;'>
			<div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'>
			<h1>
				<?= $name ?>
			</h1>
			</div>
			<div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'>
			<p>
				<?= $description ?>
			</p>
			</div>
                      <!--maps-->
                      <div class='col-md-12' style='margin-left: -15px; margin-top: 20px;'><span class='header header-large'>Map</span></div>
                      <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'><p class='bg-warning' align='center' style='padding-top: 15px; padding-bottom: 15px;'><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> The exact address of the class will be emailed to you once your request is accepted by Colin.</p></span></div>

                      <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2885.2783807043675!2d-79.30235888518642!3d43.683975658459296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cc1a1f985ddf%3A0x6be02d40c4bdd655!2sUpper+Beaches%2C+Toronto%2C+ON!5e0!3m2!1sen!2sca!4v1460762987826" width='100%' height="250" frameborder="0" style="border:0" allowfullscreen></iframe></span></div>

                </div>
                <div class='col-md-3' style='margin-left: -15px;'>
                  <div class='col-md-12' style='margin-left: -15px; margin-top: 43px; margin-bottom: 20px;'>
                    <center><span class='price'>$0 / Person</span></center>
                  </div>
                  <div class='col-md-12 bg-warning' style='margin-left: -15px; margin-top: 10px; margin-bottom: 20px;'>
                    <p><center><span class='small'>This class fee is $0, but the instructors requires $10 for ingredients.</span></center></p>
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
                  <div class='col-md-12' style='margin-left: -15px;'>
                    <select name='session' class="form-control">
                      <option>Select Time</option>
			<?php
				foreach ($sessions as $session) {
				$session_time = strtotime($session['date']);
                                $day = '';
                                switch ($session['repeat']) {
                                        case 'onetime':
                                                $day = date('l, F jS', $session_time);
                                                break;
                                        case 'weekly':
                                                $day = "Repeats " . date('l', $session_time) . " of every week.";
                                                break;
                                        case 'monthly':
                                                $day = "Repeats " . date('jS', $session_time) . " of every month.";
                                                break;
                                        default:
                                                echo "repeat unknown";
                                                break;
                                }
			?>
                      <option value='<?= $session['id'] ?>'>(<?= $session['seats'] . " Slots) " . date('G:iA', $session_time) . " - " . $day; ?></option>
			<?php } ?>
                    </select>
                  </div>
		-->
                  <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'>
                    <center><button type='submit' form='select_session' class='btn btn-success' style='width: 100%;'><a href='<?= $request_form ?>'>Request Now</a></button></center>
                  </div>
		</form>
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
	// this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_test_5Ir0zjoUeZUgOHIWP4WRYVid');
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
            $(document).ready(function() {
                $("#select_session").submit(function(event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            });

    </body>
</html>
