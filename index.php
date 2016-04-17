<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
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
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800' rel='stylesheet' type='text/css'>
        <style>
        .header {font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .price {font-family: 'Open Sans', sans-serif; font-weight: 300; font-size: 25px;}
        .header-large {font-size: 25px;}
        p {line-height: 1.7em; font-size: 15px; color: #333; }
        .request {background-color: #fc6472; padding-top: 8px; padding-bottom: 8px; font-size: 18px; color: #fff;font-family: 'Open Sans', sans-serif; font-weight: 300;}
        .small {font-size: 12px !important;}
        .intro-heading {font-family: 'Open Sans', sans-serif; font-weight: 800; font-size: 3vw; color: #fff;}
        .sub-heading {font-family: 'Open Sans', sans-serif; font-weight: 800; font-size: 1.3vw; color: #fff;}
        .browse-class {background-color: #5cb85c; border: 1px solid #4cae4c; width: 230px; padding-top: 8px; padding-bottom: 8px; margin-top: 10px; margin-left: 15px;}
        .browse-class:hover {background-color: #4cae4c; cursor: pointer;}
        </style>
    </head>
    <body style='margin-top: 40px;'>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=377900289009078";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
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
			<div id='left-nav'>
			<?= include("piqpass_nav.php"); ?>
                </p>
                </div>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px; margin-bottom: 50px;'>
                <div class='col-md-12' style='margin-left: -15px;'>
                    <!--Big Screen-->
                    <div class='col-md-12' style='height: 450px; background-image: url("img/bg.jpg"); background-position: center; background-size: cover;'>
                        <div class='col-md-12' style='margin-left: 20px; padding-top: 120px;'><span class='intro-heading' style='background-color:rgba(0, 0, 0, 0.5); padding-left: 15px; padding-right: 15px;'>COOKING CLASSES BY NEIGHBOURS.</span></div>
                        <div class='col-md-12' style='margin-top: 10px; margin-left: 20px;'><span class='sub-heading' style='background-color:rgba(0, 0, 0, 0.5); padding-left: 15px; padding-right: 15px; padding-top: 5px; padding-bottom: 5px;'>CUISINES INCLUDE FRENCH, CHINESE, GREEK, ITALIAN, INDIAN, AND SO MUCH MORE.</span></div>
                        <div class='col-md-12' style='margin-top: 10px; margin-left: 5px;'>
                          <div class='browse-class'><center><span class='sub-heading'>BROWSE CLASSES</span></center></div>
                        </div>
                    </div>
                    <!--3 Footer Notes-->
                    <div class='col-md-8' style='margin-left: -15px;'>
                        <div class='col-md-12' style='margin-left: -15px; margin-top: 40px;'>
                          <span class='header header-large'>The Vision</span>
                        </div>
                        <div class='col-md-12' style='margin-left: -15px; margin-top: 15px;'>
                          <p>Some of us might be professional chefs, while others may have other occupations. Regardless, we all come from different walks of life...and these paths have influenced the dishes we make. Wouldn't you like to experience the lives of others in your city?</p>
                          <p>Piq is a social marketplace to take cooking classes from your neighbours. Experience where people in your city comes from, how they lived their lives, and the type of people they are through the dishes they pass onto you.</p>
                          <p><i>Discover your city.</i></p>
                        </div>
                    </div>
                    <div class='col-md-4' style='margin-left: -15px;'>
                        <div class='col-md-12' style='margin-left: -15px; margin-top: 40px;'>
                          <span class='header header-large'>Do You Believe In piq?</span>
                        </div>
                        <div class='col-md-12' style='margin-left: -15px; margin-top: 15px;'>
                            <div class="fb-page" data-href="https://www.facebook.com/PIQpass/" data-tabs="timeline" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/PIQpass/"><a href="https://www.facebook.com/PIQpass/">PIQ Pass</a></blockquote></div></div>
                        </div>
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
