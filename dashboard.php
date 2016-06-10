<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

if (!$loggedInUser) {
	header('Location: login.php');
}

require_once("db/connect.php");

if (!($result = $mysqli_piq->query("select * from request where user_id = " . $loggedInUser->user_id))) {
        echo "DB Query failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
        $session_ids = [];
	$pending_reqs = [];
        $approved_reqs = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                if ($row['status'] == 'approved') {
                	$approved_reqs[] = $row;
			$session_ids[] = $row['session_id'];
			$class_ids[] = $row['class_id'];
                }
        }

	// put all sessions in hash with session_id as key for ease of access
	if (!empty($session_ids)) {
		$sessions = [];
		$stmt = $mysqli_piq->query("select * from session where id in (" . implode(',', $session_ids) . ")");
		while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
			$sessions[$row['id']] = $row;
		}
		$stmt->close();
	}

	if (!empty($approved_reqs)) {
		$addresses = [];
		$images = [];
		$stmt = $mysqli_piq->query("select id, image, address from class where id in (". implode(',', $class_ids) . ")");
		while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
                        $addresses[$row['id']] = $row['address'];
			$images[$row['id']] = $row['image'];
                }
                $stmt->close();
	}
}

$result->close();

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dashboard | Piq - Toronto Cooking Classes</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/style.css">
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
        <div class='row center-row'>
            <!--header-->
            <div class='col-md-12'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
			          <?php include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
						<?php if (empty($approved_reqs)) { ?>
						<div class='col-md-12' style='margin-top: 40px;'>
                <div class='col-md-6' style='margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='height: 300px; border: 4px dashed #f6edc1;'>
                        <div class='col-md-12'style='margin-top: 120px;'><span ><center><a href='./browse.php' class='btn btn-default'>Browse Classes</a></center></span></div>
                    </div>
                </div>
            </div>
						<?php }
                        if (!empty($pending_reqs)) {
                                echo "<div class='col-md-12'><h4 style='margin-top: 20px; float:left;'>Pending requests</h4></div>";
                        }
                        foreach ($pending_reqs as $request) {
                ?>
            <div class='col-md-12'>
                <div class='col-md-4' style='margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='margin-top: 10px;'><p><strong>Class:</strong> <?= $request['class_name'] ?></p></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                        <a href="class_stripe.php?class_id=<?= $request['class_id'] ?>" class='btn btn-default btn-sm'>View Class</a>
                    </div>
                </div>
            </div>
                <?php } ?>

            <?php
                        if (!empty($approved_reqs)) {
                                echo "<div class='col-md-12' style='margin-top: 30px;'><h4 class='header header-large' style='margin-top: 20px; float:left; margin-left: 15px;'>Confirmed Registrations</h4></div> \n
																<div class='col-md-12'>";
                        }
                        foreach ($approved_reqs as $request) {
                ?>

                <div class='col-md-4' style='margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='height: 300px; background-image: url("<?= IMAGE_PATH . $images[$request['class_id']] ?>"); background-position: center; background-size: cover;'>&nbsp;</div>
										<div class='col-md-12' style='margin-left: -15px; margin-top: 15px;'><p><strong><?= $request['class_name'] ?></strong></p></div>
										<div class='col-md-12' style='margin-left: -15px;' >
											<?php
												$s = $sessions[$request['session_id']];
												$session_time = strtotime($s['date']);
							          $day = date('l, F jS', $session_time); ?>
							          <p>Time: <?= date('G:iA', $session_time) . " - " . $day; ?></p>
										</div>
		                <div class='col-md-12' style='margin-left: -15px;' ><p>Seat: 1 Person</p></div>
		                <div class='col-md-12' style='margin-left: -15px;'><p>Address: <?= $addresses[$request['class_id']] ?></p></div>
                    <div class='col-md-12' style='margin-left: -15px;'>
                        <a href="class_stripe.php?id=<?= $request['class_id'] ?>" class='btn btn-default btn-sm'>View Class</a>
                    </div>
                </div>
                <?php }
								if (!empty($approved_reqs)) { ?>
										<div class='col-md-4 neg-15' style='margin-bottom: 20px; margin-top: 10px;'>
		                    <div class='col-md-12' style='height: 200px; border: 4px dashed #f6edc1;'>
		                        <div class='col-md-12'style='margin-top: 80px;'><span ><center><a href='./browse.php' class='btn btn-default'>Browse More Classes</a></center></span></div>
		                    </div>
		                </div>
								<?php
								echo "</div>";
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
            ga('create','UA-76836253-1','auto');ga('send','pageview');
        </script>
    </body>
</html>
