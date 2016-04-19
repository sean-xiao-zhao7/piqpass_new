<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

require_once("db/connect.php");

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

$stmt->bind_result($name, $description, $image, $price, $user_id, $address, $intersection, $user_id);
$stmt->fetch();

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
                  <div class='col-md-12' style='margin-left: -15px;'>
                    <select class="form-control">
                      <option>Select Time</option>
                      <option>(2 Slots) 7:00PM - Thursday, April 14, 2016</option>
                    </select>
                  </div>
                  <div class='col-md-12' style='margin-left: -15px; margin-top: 10px;'>
                    <center><a href='#' class='btn btn-success' style='width: 100%;'>Request Now</a></center>
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
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
