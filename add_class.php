<?php

require_once("models/config.php");
require_once("utils/utils.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

//Forms posted
if(isset($_POST['submit']))
{
	$class_name = trim($_POST["name"]);
	$image = false;
	if (file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
		$image = true;
	}
	$description = trim($_POST["class_description"]);
	$intersection = trim($_POST["intersection"]);
	$address = trim($_POST["address"]);
	$price = trim($_POST["price"]);
	$user_id = trim($_POST["user_id"]);
	$request_form = trim($_POST["request_form"]);

	$target_dir = "img/";
	$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
	$target_file = random_string(15) . "." . $imageFileType;
	$uploadOk = 1;

	// Check if image file is a actual image or fake image
	$message = false;
	if($image) {
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check === false) {
			$message = "File is not an image - " . $check["mime"] . ".";
		} else if ($_FILES["image"]["size"] > 1000000) {
			$message = "Sorry, your file is too large.";
		} else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		} else {

			if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $target_file)) {
				$message = "Sorry, there was an error uploading your file.";
			} else {
				// echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
				$image = $target_file;
			}
		}
		if ($message) { echo $message; die(); }
	}

	if ($message === false) {

		$mysqli_piq = new mysqli($db_host_piq, $db_user_piq, $db_pass_piq, $db_name_piq);
		//GLOBAL $mysqli_piq;

		if(mysqli_connect_errno()) {
			echo "Connection Failed: " . mysqli_connect_errno();
			exit();
		}

		if (!($stmt = $mysqli_piq->prepare("INSERT INTO class (name, image, description, intersection, address, price, request_form, user_id, approval) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')"))) {
			echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
		}

		if (!$stmt->bind_param("sssssdsi", $class_name, $image, $description, $intersection, $address, $price, $request_form, $user_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->close();

		// redirect to new class page
		if (!($result = $mysqli_piq->query("select max(id) as id from class where user_id = " . $loggedInUser->user_id))) {
			echo "Select query failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
		} else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			header('Location: class_stripe.php?class_id=' . $row['id']);
			$result->close();
		}
	}
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
        <link rel="stylesheet" href="css/style.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="js/vendor/trumbowyg/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
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
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class='row center-row'>
            <!--header-->
            <div class='col-md-12 header'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
								<?php include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12 neg-15' style='margin-top: 40px;'>
                <div class='col-md-8' style='margin-bottom: 50px;'>
                    <div class='col-md-12 header header-large' style='margin-top: 20px;'>Add A Class</div>
									  <div class='col-md-12' style='margin-top: 5px;'><p><i>All new classes will be approved within 24 hours before it goes live in the "Browse" section.</i></p></div>
                    <div class='col-md-12' style='margin-top: 20px;'>
			<?php
				if ($message !== false) {
			?>
				<div><?= $message ?></div>
			<?php } ?>
                      <form id='add_class_form' name='add_class_form' action='<?= $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
											<div class="form-group">
                        <label for="exampleInputEmail1">Class Name</label>
                        <input name="name" class="form-control" id="name" placeholder="Burger Making 101" value=<?= $class_name ?>>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Class Image</label>
                        <input name='image' type="file" id="image">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name='class_description' class="form-control" id='class_description' rows="3"  value="<?= $description ?>"></textarea>
                      </div>
											<!--
                      <div class="form-group">
                        <label for="exampleInputEmail1">Major Intersection (Displayed to Public)</label>
                        <input name="intersection" class="form-control" id="name" placeholder="eg. Yonge and Eglinton"  value="<?= $intersection ?>">
                      </div>
										-->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Exact Address (Only Sent to Confirmed Students)</label>
                        <input name="address" class="form-control" id="name" placeholder="eg. 12 Soudan Dr., Toronto, Ontario M3K 1K3"  value="<?= $address ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Class Fee (Number Only)</label>
                        <input name="price" class="form-control" id="confirmpass" placeholder="25"  value="<?= $price ?>">
                      </div>
											<!--<div class="form-group">
                        <label for="exampleInputEmail1">Request Form (Request from Admin)</label>
                        <input type='text' name="request_form" class="form-control" id="request_form" value="<?= $request_form ?>">
                      </div>
										-->
			<input name="user_id" type='hidden' value='<?= $loggedInUser->user_id; ?>'>
			<input name='submit' type='hidden' value=1 />
                      <button type="submit" class="btn btn-default">Add Class</button>
                      </form>
                    </div>
                </div>
								<div class='col-md-4'>
									<h2 class='header header-large'>Class Tips</h2>
									<p class='instructions'>
										<ul>
											<li>Single dish classes sell best between $18-$25 per person.</li>
											<li>Multi-course classes sell best between $45 - $66 per person.</li>
											<li>Name your classes with fun titles. For example, An evening of Mexican Taco Delights.</li>
											<li>Classes with themes sell best. For example, Spanish Cuisine.</li>
										</ul>
									</p>
									<h2 class='header header-large'>Promoting Yourself</h2>
									<p class='instructions'>
										<ul>
											<li>Share the link of your class on social media.</li>
											<li>Sharing links on LinkedIn, Facebook and Twitter gets the best results.</li>
										</ul>
									</p>
									<h2 class='header header-large'>Refund Policy</h2>
									<p class='instructions'>
										<ul>
											<li>Piq offers full refunds to students as long the order is canceled 7 days before the class. We also offer a 50% discount if they request a refund 3 days before the class. We don't offer refunds if the student cancels the day of the class. All students will be refunded 100% of the class fees if the chef cancels the class at any time.</li>
										</ul>
									</p>
									<h2 class='header header-large'>Payments</h2>
									<p class='instructions'>
										<ul>
											<li>Payments are sent to you via transfer within 24 hours the class takes place.</li>
										</ul>
									</p>
									<h2 class='header header-large'>Fees</h2>
									<p class='instructions'>
										<ul>
											<li>Piq takes a 10% fee on the course fee you set. Eg. If you set the price to $50, we pay you $45.</li>
											<li>Piq also adds 10% to the price when sold to the student. Eg. If you set the price to $50, the student pays $55.</li>
										</ul>
									</p>
								</div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
	<script src="js/vendor/trumbowyg/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
	<script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>


        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
		CKEDITOR.replace( 'class_description' );
        </script>
    </body>
</html>
