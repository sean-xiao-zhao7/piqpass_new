<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (!$loggedInUser->checkPermission(array(2)))
{
        header("Location: index.php");
}

require_once("db/connect.php");

if (isset($_GET['unapprove'])) {
	$stmt = $mysqli_piq->prepare("update class set approval = 'pending' where id = ?");
	$approved = $_GET['class_id'];
	$stmt->bind_param("s", $approved);
	$stmt->execute();
	$stmt->close();
} else if (isset($_GET['class_id'])) {
        $stmt = $mysqli_piq->prepare("update class set approval = 'approved' where id = ?");
        $approved = $_GET['class_id'];
        $stmt->bind_param("s", $approved);
        $stmt->execute();
        $stmt->close();
}

if (!($result = $mysqli_piq->query("select * from class"))) {
        echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
	$classes = [];
	$chef_ids = [];
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		if (strlen($row['description']) > 200) {
			$pattern = '/<(\w+)>/i';
			$row['description'] = preg_replace($pattern, '', substr($row['description'], 0, 200) . "... <a href='class.php?class_id=" . $row['id'] . "'>Read more</a>");
                }
		$classes[] = $row;
		$chef_ids[] = $row['user_id'];
	}
	if (!empty($chef_ids)) {
	$result2 = $mysqli->query("select id, display_name, email from users where id in (" . implode(",", $chef_ids) . ")");
	$chefs = [];
	while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
		$chefs[$row['id']] = [$row['display_name'], $row['email']];
	}
	$result2->close();
	}
}

$result->close();

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
        <link rel="stylesheet" href="css/style.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <style>
        /*
        .header {font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .price {font-family: 'Open Sans', sans-serif; font-weight: 300; font-size: 25px;}
        .header-large {font-size: 25px;}
        p {line-height: 1.7em; font-size: 15px; color: #333; }
        .request {background-color: #fc6472; padding-top: 8px; padding-bottom: 8px; font-size: 18px; color: #fff;font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .small {font-size: 12px !important;}
        */
        </style>
    </head>
    <body style='margin-top: 40px;'>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an outdated browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class='row center-row'>
            <!--header-->
            <div class='col-md-12 header neg-15'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
		            <?php include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <div class='col-md-12 bg-warning' style='margin-top: 50px; padding: 10px;'>
               <p align='center'>Added your first class? Head over to <a href='sessions_dashboard.php'>Sessions</a> to schedule times and dates for your class to happen. <a href='sessions_dashboard.php'>Schedule your classes here</a>.</p>
            /div>
            <!--Class List-->
            <div class='col-md-12 header header-large' style='margin-top: 50px; margin-bottom: 30px'>Your Classes</div>
		<?php
		foreach ($classes as $class) {
		?>
    		    <div class='col-md-12' style='margin-bottom: 70px;'>
        			<div class='col-md-5' style='height: 300px; background-image: url("<?= IMAGE_PATH . $class['image'] ?>"); background-position: center; background-size: cover;'>&nbsp;</div>
        			<div class='col-md-7 mobile-neg-15'>
        			    <div class='col-md-12 mobile-neg-15'><span class='header header-large'><a href='class_stripe.php?class_id=<?= $class['id'] ?>'><?= $class['name']; ?></a></span></div>
        			    <div class='col-md-12 mobile-neg-15' style='margin-top: 10px;'><p><?= $class['description']; ?></p></div>
        			    <div class='col-md-12 mobile-neg-15' style='margin-top: 10px;'><p><?= $chefs[$class['user_id']][0]; ?></p></div>
        			    <div class='col-md-12 mobile-neg-15' style='margin-top: 10px;'><p><?= $chefs[$class['user_id']][1]; ?></p></div>
        			    <div class='col-md-12 mobile-neg-15' style='margin-top: 10px;'>
              				<a href='class_stripe.php?class_id=<?= $class['id'] ?>' class='btn btn-sm btn-default'>View</a>
              				<a href='edit_class.php?class_id=<?= $class['id'] ?>' class='btn btn-sm btn-default'>Edit</a>
					<?php
						if ($class['approval'] == 'approved') {
					?>
					Approved
	              				<a href='<?= $_SERVER['PHP_SELF'] . '?class_id=' . $class['id'] ?>&unapprove=1' class='btn btn-sm btn-default'>Unapprove</a>
					<?php } else { ?>			
	              				<a href='<?= $_SERVER['PHP_SELF'] . '?class_id=' . $class['id'] ?>' class='btn btn-sm btn-default'>Approve</a>
					<?php } ?>
					<!--
					<form method='post' id='go2enrollment' action='class_enrollment.php'>
						<input type='hidden' name='class_id' value='<?= $class['id'] ?>' />
	              				<input type='submit' name='submit' class='btn btn-sm btn-default' value='Enrollment' />
					</form>
					-->
              		</div>
        			</div>
    		    </div>
		<?php
		}
		?>
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
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
