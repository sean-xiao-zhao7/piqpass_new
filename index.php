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
        <link rel="stylesheet" href="css/style.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800' rel='stylesheet' type='text/css'>
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
        <div class='row center-row'>
            <!--header-->
            <div class='col-md-12'>
                <div class='col-md-2'><img src='img/piqlanding1.jpg' /></div>
                <?= include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12' style='margin-top: 40px; margin-bottom: 50px;'>
                <div class='col-md-12'>
                    <!--Big Screen-->
                    <div class='col-md-12 pic-bg'>
                        <div class='col-md-12 dark-header'><span class='intro-heading intro-dark'>TAKE COOKING CLASSES</span></div>
                        <div class='col-md-12 dark-header-2nd'><span class='intro-heading-2nd intro-dark'>HOSTED BY YOUR TORONTO NEIGHBOURS.</span></div>
                        <!--<div class='col-md-12 dark-sub-header'><span class='sub-heading sub-intro-dark'>CUISINES INCLUDE FRENCH, CHINESE, GREEK, ITALIAN, INDIAN, AND SO MUCH MORE.</span></div>
                        --><div class='col-md-12 header-button'>
                          <a href='browse.php'><div class='browse-class'><center><span class='sub-heading'>BROWSE CLASSES</span></center></div></a>
                        </div>
                    </div>
                    <div class='col-md-12 neg-15'>
                        <div class='col-md-12' align='center' style='margin-top: 30px; margin-bottom: 20px;'>
                          <span class='header header-large'><strong>How It Works</strong></span>
                        </div>
                        <div class='col-md-4' align='center'style='margin-top: 20px;'>
                            <span class="glyphicon glyphicon-map-marker" aria-hidden="true" style='font-size: 10vw; color: #999;'></span><br /><br />
                            <p><span class='header header-large'>1. Browse</span><br />
                              Discover curated culinary experiences.</p>
                        </div>
                        <div class='col-md-4' align='center'style='margin-top: 20px;'>
                            <span class="glyphicon glyphicon-check" aria-hidden="true" style='font-size: 10vw; color: #999;'></span><br /><br />
                            <p><span class='header header-large'>2. Book</span><br />
                              Pay to register for the class.</p>
                        </div>
                        <div class='col-md-4' align='center'style='margin-top: 20px;'>
                            <span class="glyphicon glyphicon-heart" aria-hidden="true" style='font-size: 10vw; color: #999;'></span><br /><br />
                            <p><span class='header header-large'>3. Enjoy</span><br />
                              Arrive and experience the culinary joy.</p>
                        </div>
                    </div>
                    <div class='col-md-12 neg-15' style='margin-top: 10px;'><hr /></div>
                    <!--3 Footer Notes-->
                    <div class='col-md-12 neg-15'>
                        <div class='col-md-6 neg-15 pad-right'>
                          <div class='col-md-12 neg-15' style='margin-top: 40px;'>
                            <span class='header header-large'>The Story</span>
                          </div>
                          <div class='col-md-12 neg-15' style='margin-top: 15px;'>
                            <p>Some of us might be professional chefs, while others may have other occupations. Regardless, we all come from different walks of life...and these paths have influenced the dishes we make. Wouldn't you like to experience the lives of others in your city?</p>
                            <p>Piq is a social marketplace to take cooking classes from your neighbours. Experience where people in your city comes from, how they lived their lives, and the type of people they are through the dishes they pass onto you.</p>
                          </div>
                        </div>

                        <div class='col-md-6 neg-15'>
                          <div class='col-md-12 neg-15' style='margin-top: 40px;'>
                            <span class='header header-large'>Who Are The Chefs?</span>
                          </div>
                          <div class='col-md-12 neg-15' style='margin-top: 15px;'>
                            <p>The chefs on piq are any individuals who are confident in their cooking. They can either be professional who have over 20+ years of experience, or an hobbyist who knows their way around the kitchen.</p>
                            <p>The classes, like tutoring classes, take place in the home of the chefs. At times, classes will also be held in professional kitchens at the discretion of the chefs.</p>
                            <p></p>
                          </div>
                        </div>
                    </div>
                    <div class='col-md-12 neg-15' style='margin-top: 10px;'><hr /></div>
                    <!--Social Media-->
                    <div class='col-md-12 neg-15' align='center' style='margin-top: 20px; margin-bottom: 20px;'>
                      <span class='header header-large'>Support Us on Social Media</span>
                    </div>
                    <div class='col-md-12 neg-15' align='center'>
                      <ul class="soc">
                        <li><a class="soc-facebook" href="http://www.facebook.com/trypiq"></a></li>
                        <li><a class="soc-instagram" href="http://www.instagram.com/trypiq"></a></li>
                        <li><a class="soc-twitter " href="http://www.twitter.com/trypiq"></a></li>
                        <li><a class="soc-email2 soc-icon-last" href="hi@trypiq.com"></a></li>
                      </ul>
                    </div>
                    <div class='col-md-12' align='center' style='margin-top: 50px;'>
                      <p>&copy; 2016 All Right Reserved. PIQ</p>
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
