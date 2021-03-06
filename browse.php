<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

require_once("db/connect.php");

if (!($result = $mysqli_piq->query("select * from class where approval = 'approved' order by id desc"))) {
        echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
        $classes = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		if (strlen($row['description']) > 200) {
			$pattern = '/<(\w+)>/i';
			$row['description'] = preg_replace($pattern, '', substr($row['description'], 0, 200) . "... <a href='class_stripe.php?class_id=" . $row['id'] . "'>Read more</a>");
		}
                $classes[] = $row;
        }
}

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
            <div class='col-md-12 header'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
		            <?php include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12 header header-large' style='margin-top: 40px; margin-left: 15px;'>Browse Classes</div>
            <div class='col-md-12' style='margin-top: 40px;'>
		<?php
		foreach ($classes as $class) {
		?>
                <div class='col-md-6' style='height: 510px;'>
                    <a href='class_stripe.php?class_id=<?= $class['id'] ?>'><div class='col-md-12 class_logo_container' style='height: 300px; background-image: url("<?= IMAGE_PATH . $class['image'] ?>"); background-position: center; background-size: cover;'>&nbsp;</div></a>
                    <div class='col-md-12 header header-large neg-15' style='margin-top: 20px;'><a href='class_stripe.php?class_id=<?= $class['id'] ?>'><?= $class['name']; ?></a></div>
                    <div class='col-md-12 neg-15' style='margin-top: 10px;'>
                        <p><?= $class['description']; ?></p>
                    </div>
                </div>
		<?php
		}
		?>
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
