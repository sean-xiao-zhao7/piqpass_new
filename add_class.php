<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	//print_r($_POST); die();
	$name = trim($_POST["name"]);
	$image = $_POST["image"] ? trim($_POST["image"]) : "";
	$description = trim($_POST["description"]);
	$intersection = trim($_POST["intersection"]);
	$address = trim($_POST["address"]);
	$price = trim($_POST["price"]);
	$uesr_id = trim($_POST["user_id"]);

	$mysqli_piq = new mysqli($db_host_piq, $db_user_piq, $db_pass_piq, $db_name_piq);
	//GLOBAL $mysqli_piq;

	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
		
	if (!($stmt = $mysqli_piq->prepare("INSERT INTO class (name, image, description, intersection, address, price, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)"))) {
		echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
	}

	if (!$stmt->bind_param("sssssdi", $name, $image, $description, $intersection, $address, $price, $user_id)) {
	    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
	
}

require_once("models/header.php");

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
			<?= include("piqpass_nav.php"); ?>
                </p>
                </div>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px; margin-left: -15px;'>
                <div class='col-md-6' style='margin-left: -15px; margin-bottom: 50px;'>
                    <div class='col-md-12 header header-large' style='margin-top: 20px;'>Add A Class</div>
                    <div class='col-md-12' style='margin-top: 20px;'>
                      <form id='add_class_form' name='add_class_form' action='<?= $_SERVER['PHP_SELF'] ?>' method=post>
				<div class="form-group">
                        <label for="exampleInputEmail1">Class Name</label>
                        <input name="name" class="form-control" id="name" placeholder="Burger Making 101">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Logo</label>
                        <input name='image' type="file" id="exampleInputFile">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name='description' class="form-control" rows="3"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Major Intersection (Displayed to Public)</label>
                        <input name="intersection" class="form-control" id="name" placeholder="eg. Yonge and Eglinton">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Exact Address (Sent to Confirmed Students)</label>
                        <input name="address" class="form-control" id="name" placeholder="eg. 12 Soudan Dr., Toronto, Ontario M3K 1K3">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Class Fee (Number Only)</label>
                        <input name="price" class="form-control" id="confirmpass" placeholder="25">
                      </div>
			<input name="user_id" type='hidden' value='<?= $loggedInUser->user_id; ?>'>
                      <button type="submit" class="btn btn-default">Add Class</button>
                      </form>
                    </div>
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
