<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (!$loggedInUser->checkPermission(array(3)))
{
 	header("Location: index.php");
}
require_once("db/connect.php");
//print_r($_POST); die();
if(!empty($_POST)) {
	//print_r($_POST); die();
	
	if (!($stmt = $mysqli_piq->prepare("insert into session (`seats`, `time`, `date`, `class_id`, `repeat`) values(?, 0, cast(? as datetime), ?, ?)"))) {
		echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
	}
	
	$repeat = "daily";
	$dummy = 0;
	//echo $_POST['time'] . ' ' . strtotime($_POST['time']) . ", " . $_POST['date'] . ", " . date('Y-m-d H:i:s', strtotime($_POST['date'] . ' ' . $_POST['time']));	
	//die();
	if (strpos($time, "am")) {
		$time = str_replace($time, "am", '');
	} else {
		 $time = str_replace($time, "pm", '');
	}
	if (!$stmt->bind_param("isis", $_POST['slots'], date('Y-m-d H:i:s', strtotime($_POST['date'] . ' ' . $_POST['time'])), $_POST['class_id'], $repeat)) {
	    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
	
}

if (isset($_GET['delete'])) {
	if (!($stmt = $mysqli_piq->prepare("delete from session where id = ?"))) {
                echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
        }

        if (!$stmt->bind_param("i", $_GET['delete'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
}

if (!($result = $mysqli_piq->query("select id, name from class where user_id = " . $loggedInUser->user_id))) {
        echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
        $classes = [];
	$class_ids = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $classes[] = $row;
		$class_ids[] = $row['id'];
        }
}

if (!($result2 = $mysqli_piq->query("select * from session where class_id in (" . implode(",", $class_ids) . ")"))) {
        echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
} else {
        $sessions = [];
        while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
                $sessions[$row['class_id']][] = $row;
        }
}

$result->close();
$result2->close();

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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href="utils/jquery-timepicker/jquery_timepicker.css"  rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <style>
        .header {font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .price {font-family: 'Open Sans', sans-serif; font-weight: 300; font-size: 25px;}
        .header-large {font-size: 25px;}
        .header-medium {font-size: 17px;}
        p {line-height: 1.7em; font-size: 15px; color: #333; }
        .request {background-color: #fc6472; padding-top: 8px; padding-bottom: 8px; font-size: 18px; color: #fff;font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .small {font-size: 12px !important;}
        .grey_td {padding:8px;}
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
                <a href='requests_dashboard.php' class='btn btn-default'>Requests</a>&nbsp;
                <a href='class_dashboard.php' class='btn btn-default'>Classes</a>&nbsp;
                <a href='#' class='btn btn-default disabled'>Sessions</a>
            </div>
            <!--Class List-->
		<?php
			foreach ($classes as $class) {
		?>
            <div class='col-md-12' style='margin-top: 20px;'>
                <div class='col-md-3' style='background-color: #999; height: 220px; margin-bottom: 20px; margin-top: 10px;'>&nbsp;</div>
                <div class='col-md-9'>
                    <div class='col-md-12'><span class='header header-large'><?= $class['name'] ?></span></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                      <form class="form-inline" method='post' action='<?= $_SERVER['PHP_SELF'] ?>' id='add_session_form'>
			<input type='hidden' name='class_id' value='<?= $class['id'] ?>'>
                      <div class="form-group">
                        <label for="time" style='font-weight: 300px;'>Time:</label>
                        <input name='time' type="text" class="form-control" id="time" style='font-size: 12px' placeholder="Eg. 7:00PM">
                      </div>
                      <div class="form-group"  data-provide="datepicker">
                        <label for="date" style='font-weight: 300px; margin-left: 20px;'> Date:</label>
                        <input name='date' type="text" class="form-control" style='width: 180px; font-size: 12px;' id="date" data-provide="datepicker">
                      </div>
			<div class="form-group">
                        <label for="date" style='font-weight: 300px; margin-left: 20px;'> Slots:</label>
                        <input name='slots' type="text" class="form-control" style=' font-size: 12px;' id="slots" size='5' maxlength='5'>
                      </div>
			<div class="form-group">
                        <label for="repeat" style='font-weight: 300px; margin-left: 20px;'> Frequency:</label>
			<select name='repeat'  class="form-control" style=' font-size: 12px;' id="repeat">
			  <option value="onetime">One time</option>
			  <option value="daily">Daily</option>
			  <option value="weekly">Weekly</option>
			  <option value="biweekly">Bi-weekly</option>
			  <option value="monthly">Monthly</option>
			  <option value="bimonthly">Bi-monthly</option>
			</select>
                      </div>
                      <button type="submit" class="btn btn-default" form='add_session_form' value='Add Session'>Add Session</button>
                      </form>
                    </div>
			<div class='col-md-12' style='margin-top: 20px;'>
                        <table style='width: 100%;'>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>Time</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Day</span></td>
                                <td class='grey_td' style='width: 20%;'>&nbsp;</td>
                            </tr>
                    <!--Session-->
			<?php	
				if (!empty($sessions)) {
				foreach ($sessions[$class['id']] as $session) {
				$session_datetime = $session['date'];				
				$day = date('l, F jS', strtotime($session_datetime));
				if ($session['repeat'] != 'onetime') {
					$day = 'Repeated ' . $session['repeat'] . '. Next session ' . $day;
				}				
			?>
                            <!--Times-->
                            <tr>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'><?= date('G:iA', strtotime($session_datetime)) ?></span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'><?= $day ?></span></td>
                                <td class='grey_td' style='width: 20%;'><a href='<?= $_SERVER['PHP_SELF'] . "?delete=" . $session['id'] ?>' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
			 <?php } } ?>
                        </table>
                    </div>
                </div>
            </div>
		<?php } ?>
        </div>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script src="utils/jquery-timepicker/jquery.timepicker.min.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
		$('#date').datepicker();
		$('#time').timepicker();
        </script>
    </body>
</html>
