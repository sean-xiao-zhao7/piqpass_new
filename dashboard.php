<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
require_once("db/connect.php");

if (!($result = $mysqli_piq->query("select * from request where user_id = " . $loggedInUser->user_id))) {
        echo "DB Query failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
        $pending_reqs = [];
        $approved_reqs = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                if ($row['status'] == 'pending') {
                        $pending_reqs[] = $row;
                }
                else if ($row['status'] == 'approved') {
                        $approved_reqs[] = $row;
                }
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
			<?= include("piqpass_nav.php"); ?>
                </div>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px;'>		
                <div class='col-md-6' style='margin-left: -15px; margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='height: 300px; border: 4px dashed #f6edc1;'>
                        <div class='col-md-12'style='margin-top: 120px;'><span ><center><a href='./browse.php' class='btn btn-default'>Browse Classes</a></center></span></div>
                    </div>
                </div>
            </div>

		<?php
                        if (!empty($pending_reqs)) {
                                echo "<h4 style='margin-top: 20px; float:left; margin-left: 15px;'>Pending requests</h4>";
                        }
                        foreach ($pending_reqs as $request) {
                ?>
            <div class='col-md-12' style='margin-left: -15px;'>
                <div class='col-md-4' style='margin-left: -15px; margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='margin-top: 10px;'><p><strong>Class:</strong> <?= $request['class_name'] ?></p></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                        <a href="class.php?id=<?= $request['class_id'] ?>" class='btn btn-default btn-sm'>View Class</a>
                    </div>
                </div>
            </div>
                <?php } ?>

            <?php
                        if (!empty($approved_reqs)) {
                                echo "<h4 style='margin-top: 20px; float:left; margin-left: 15px;'>Approved requests</h4>";
                        }
                        foreach ($approved_reqs as $request) {
                ?>
            <div class='col-md-12' style='margin-left: -15px;'>
                <div class='col-md-4' style='margin-left: -15px; margin-bottom: 20px; margin-top: 10px;'>
                    <div class='col-md-12' style='margin-top: 10px;'><p><strong>Class:</strong> <?= $request['class_name'] ?></p></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                        <a href="class.php?id=<?= $request['class_id'] ?>" class='btn btn-default btn-sm'>View Class</a>
                    </div>
                </div>
            </div>
                <?php }
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
