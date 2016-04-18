<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (!$loggedInUser->checkPermission(array(3)))
{
 	header("Location: index.php");
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
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
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
            <div class='col-md-12' style='margin-top: 20px;'>
                <div class='col-md-3' style='background-color: #999; height: 220px; margin-bottom: 20px; margin-top: 10px;'>&nbsp;</div>
                <div class='col-md-9'>
                    <div class='col-md-12'><span class='header header-large'>Chinese Cooking 101</span></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                      <form class="form-inline">
                      <div class="form-group">
                        <label for="time" style='font-weight: 300px;'>Time:</label>
                        <input type="text" class="form-control" id="time" style='font-size: 12px' placeholder="Eg. 7:00PM">
                      </div>
                      <div class="form-group">
                        <label for="date" style='font-weight: 300px; margin-left: 20px;'> Date:</label>
                        <input type="text" class="form-control" style='width: 280px; font-size: 12px;' id="date" placeholder="Eg. Every Monday or Saturday, April 16, 2016">
                      </div>
                      <button type="submit" class="btn btn-default">Add Session</button>
                      </form>
                    </div>
                    <!--Session-->
                    <div class='col-md-12' style='margin-top: 20px;'>
                        <table style='width: 100%;'>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>Time</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Day</span></td>
                                <td class='grey_td' style='width: 20%;'>&nbsp;</td>
                            </tr>
                            <!--Times-->
                            <tr>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Every Thursday</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Monday, April 15, 2016</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!--Class List-->
            <div class='col-md-12' style='margin-top: 20px;'>
                <div class='col-md-3' style='background-color: #999; height: 220px; margin-bottom: 20px; margin-top: 10px;'>&nbsp;</div>
                <div class='col-md-9'>
                    <div class='col-md-12'><span class='header header-large'>Chinese Cooking 101</span></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                      <form class="form-inline">
                      <div class="form-group">
                        <label for="time" style='font-weight: 300px;'>Time:</label>
                        <input type="text" class="form-control" id="time" style='font-size: 12px' placeholder="Eg. 7:00PM">
                      </div>
                      <div class="form-group">
                        <label for="date" style='font-weight: 300px; margin-left: 20px;'> Date:</label>
                        <input type="text" class="form-control" style='width: 280px; font-size: 12px;' id="date" placeholder="Eg. Every Monday or Saturday, April 16, 2016">
                      </div>
                      <button type="submit" class="btn btn-default">Add Session</button>
                      </form>
                    </div>
                    <!--Session-->
                    <div class='col-md-12' style='margin-top: 20px;'>
                        <table style='width: 100%;'>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>Time</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Day</span></td>
                                <td class='grey_td' style='width: 20%;'>&nbsp;</td>
                            </tr>
                            <!--Times-->
                            <tr>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Every Thursday</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Monday, April 15, 2016</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!--Class List-->
            <div class='col-md-12' style='margin-top: 20px;'>
                <div class='col-md-3' style='background-color: #999; height: 220px; margin-bottom: 20px; margin-top: 10px;'>&nbsp;</div>
                <div class='col-md-9'>
                    <div class='col-md-12'><span class='header header-large'>Chinese Cooking 101</span></div>
                    <div class='col-md-12' style='margin-top: 10px;'>
                      <form class="form-inline">
                      <div class="form-group">
                        <label for="time" style='font-weight: 300px;'>Time:</label>
                        <input type="text" class="form-control" id="time" style='font-size: 12px' placeholder="Eg. 7:00PM">
                      </div>
                      <div class="form-group">
                        <label for="date" style='font-weight: 300px; margin-left: 20px;'> Date:</label>
                        <input type="text" class="form-control" style='width: 280px; font-size: 12px;' id="date" placeholder="Eg. Every Monday or Saturday, April 16, 2016">
                      </div>
                      <button type="submit" class="btn btn-default">Add Session</button>
                      </form>
                    </div>
                    <!--Session-->
                    <div class='col-md-12' style='margin-top: 20px;'>
                        <table style='width: 100%;'>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>Time</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Day</span></td>
                                <td class='grey_td' style='width: 20%;'>&nbsp;</td>
                            </tr>
                            <!--Times-->
                            <tr>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Every Thursday</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                            <tr style='background-color: #f1f1f1;'>
                                <td class='grey_td' style='width: 20%;'><span class='header header-medium'>7:00PM</span></td>
                                <td class='grey_td' style='width: 60%;'><span class='header header-medium'>Monday, April 15, 2016</span></td>
                                <td class='grey_td' style='width: 20%;'><a href='#' class='btn btn-sm btn-danger'>Delete</a> </td>
                            </tr>
                        </table>
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
