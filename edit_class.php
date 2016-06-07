<?php

require_once("models/config.php");
require_once("utils/utils.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_GET) || isset($_POST['class_id'])){
	require_once("db/connect.php");

	$stmt = $mysqli_piq->prepare("select * from class where id = ?");
	$class_id = ($_POST['class_id'] ? $_POST['class_id'] : $_GET['class_id']);
	$stmt->bind_param("i", $class_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($class_name, $description, $image, $price, $user_id, $address, $intersection, $class_id, $request_form, $approval);
	$stmt->fetch();
	$stmt->close();
	if (!$loggedInUser->checkPermission(array(2)) && $user_id != $loggedInUser->user_id) {
		header("Location: class_dashboard.php"); 
		die();
	}

	if (isset($_GET['delete'])) {
		$stmt = $mysqli_piq->prepare("delete from class where id = ?");
		$stmt->bind_param('i', $_GET['class_id']);
		$stmt->execute();
		$stmt->close();
		header("Location: class_dashboard.php");
		die();
	}
}

if(isset($_POST['gallery'])) {
	$message = '';
	$imageFileType = pathinfo($_FILES["new_gallery_image"]["name"],PATHINFO_EXTENSION);
	$target_file = random_string(15) . "." . $imageFileType;
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["new_gallery_image"]["tmp_name"]);
	    if($check !== false) {
		$message ="File is an image - " . $check["mime"] . ".";
	    } else {
		$message ="File is not an image.";
	    }
	}

	// Check file size
	if ($_FILES["new_gallery_image"]["size"] > 10000000) {
	    $message ="Error: File upload limit is 10MB.";
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $message ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}

	if ($message == '') {
		if (!file_exists(IMAGE_PATH . $_POST['class_id'])) {
			mkdir(IMAGE_PATH . $_POST['class_id']);
		}
	    if (!move_uploaded_file($_FILES["new_gallery_image"]["tmp_name"], IMAGE_PATH . $_POST['class_id'] . "/" . $target_file)) {
		$message ="Sorry, there was an error uploading your file.";
	    } else {
		$message ="The file ". basename( $_FILES["new_gallery_image"]["name"]). " has been uploaded.";
		$image = $target_file;	
		error_log($message);	
	    }
	} else {
		error_log("could not upload gallery image: $message");
	}

} else if(!empty($_POST))
{
	$class_name = trim($_POST["name"]);
	$class_id = trim($_POST["class_id"]);
	$old_image = $_POST["old_image"];
	$description = trim($_POST["class_description"]);
	$intersection = trim($_POST["intersection"]);
	$address = trim($_POST["address"]);
	$price = trim($_POST["price"]);
	$request_form = trim($_POST["request_form"]);
	$user_id = trim($_POST["user_id"]);

	$uploadOk = 1;
	$uploaded = false;
	if (file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
		$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
		$target_file = random_string(15) . "." . $imageFileType;
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["image"]["tmp_name"]);
		    if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		    } else {
			echo "File is not an image.";
			$uploadOk = 0;
		    }
		}

		// Check file size
		if ($_FILES["image"]["size"] > 10000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (!move_uploaded_file($_FILES["image"]["tmp_name"], IMAGE_PATH . $target_file)) {
			echo "Sorry, there was an error uploading your file.";
		    } else {
			echo "The file ". basename($_FILES["image"]["name"]). " has been uploaded.";
			echo $target_file;
			$image = $target_file;
			$uploaded = true;
			unlink($_POST["old_image"]);			
			}
		}
	} 
	
	$mysqli_piq = new mysqli($db_host_piq, $db_user_piq, $db_pass_piq, $db_name_piq);
	//GLOBAL $mysqli_piq;

	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}

	if ($uploaded) {
		$pq = "update class set name=?, image=?, description=?, intersection=?, address=?, price=?, request_form=? where id=?";
	} else {
		$pq = "update class set name=?, description=?, intersection=?, address=?, price=?, request_form=? where id=?";
	}

	if (!($stmt = $mysqli_piq->prepare($pq))) {
		echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
	}

	if ($uploaded) {
		if (!$stmt->bind_param("sssssdsi", $class_name, $image, $description, $intersection, $address, $price, $request_form, $class_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	} else {
		if (!$stmt->bind_param("ssssdsi", $class_name, $description, $intersection, $address, $price, $request_form, $class_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
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
            <div class='col-md-12'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
								<?php include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12 neg-15' style='margin-top: 40px;'>
		<div><?= $message ?></div>
                <div class='col-md-8' style='margin-bottom: 50px;'>
                    <div class='col-md-12 header header-large' style='margin-top: 20px;'>Edit Class: <?= $class_name ?></div>

			<div class='col-md-12' style='margin-top: 20px;'>
				<form id='gallery_form' action='<?= $_SERVER['PHP_SELF'] ?>?class_id=<?= $class_id ?>' method='post' enctype="multipart/form-data">
					 <div class="form-group">
                        			<label for="exampleInputFile">Add an image to gallery</label>
						<input name='class_id' value='<?= $class_id ?>' type='hidden' />
			                        <input name='new_gallery_image' type="file" id="new_gallery_image">
						<input name='gallery' value='1' type='hidden'/>
						<button type="submit" class="btn btn-default">Submit</button>					
                			 </div>
				</form>
			</div>

                    <div class='col-md-12' style='margin-top: 20px;'>
                      <form id='add_class_form' name='add_class_form' action='<?= $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
			<input type='hidden' name='old_image' value='<?= $image ?>'>
				<div class="form-group">
                        <label for="exampleInputEmail1">Class Name</label>
                        <input name="name" class="form-control" id="name" placeholder="Burger Making 101" value="<?= $class_name ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Logo image</label>
			<?php if (isset($image)) { ?>
				<img class='class_logo' src='<?= IMAGE_PATH . $image ?>' />
			<?php } ?>
                        <input name='image' type="file" id="image">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name='class_description' class="form-control" id='class_description' rows="3"><?= $description ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Major Intersection (Displayed to Public)</label>
                        <input name="intersection" class="form-control" id="name" placeholder="eg. Yonge and Eglinton"  value="<?= $intersection ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Exact Address (Sent to Confirmed Students)</label>
                        <input name="address" class="form-control" id="name" placeholder="eg. 12 Soudan Dr., Toronto, Ontario M3K 1K3"  value="<?= $address ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Class Fee (Number Only)</label>
                        <input name="price" class="form-control" id="price" placeholder="25"  value="<?= $price ?>">
                      </div>
		 <div class="form-group">
                        <label for="exampleInputEmail1">Request Form (Request from Admin)</label>
                        <input type='text' name="request_form" class="form-control" id="request_form" value="<?= $request_form ?>">
                      </div>
			<input name="user_id" type='hidden' value='<?= $loggedInUser->user_id; ?>'>
			<input name="class_id" type='hidden' value='<?= $class_id; ?>'>
                      <button type="submit" class="btn btn-default">Save class information</button>
                      </form>
                    </div>
			<a href='<?= $_SERVER['PHP_SELF'] ?>?delete=1&class_id=<?= $class_id ?>' onclick="return confirm('Are you sure?')" >Delete class</a>
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

	<script src="js/dropzone.js"></script>

    </body>
</html>
