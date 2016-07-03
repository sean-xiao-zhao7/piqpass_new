<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
        $errors = array();
        $email = trim($_POST["email"]);
        $username = trim($_POST["email"]); //trim($_POST["username"]);
        $displayname = trim($_POST["displayname"]);
        $password = trim($_POST["password"]);
        $confirm_pass = trim($_POST["passwordc"]);
        $captcha = md5($_POST["captcha"]);


        if ($captcha != $_SESSION['captcha'])
        {
                $errors[] = lang("CAPTCHA_FAIL");
        }
        if(minMaxRange(5,150,$username))
        {
                $errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,150));
        }
	/*
        if(!ctype_alnum($username)){
                $errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
        }
	*/
        if(minMaxRange(5,150,$displayname))
        {
                $errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,150));
        }
	/*
        if(!ctype_alnum($displayname)){
               $errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
        }
	*/
        if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
        {
                $errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
        }
        else if($password != $confirm_pass)
        {
                $errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
        if(!isValidEmail($email))
        {
                $errors[] = lang("ACCOUNT_INVALID_EMAIL");
        }
        //End data validation
        if(count($errors) == 0)
        {
                //Construct a user object
                $user = new User($username,$displayname,$password,$email);

                //Checking this flag tells us whether there were any errors such as possible data duplication occured
                if(!$user->status)
                {
                        if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
                        if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
                        if($user->email_taken)    $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
                }
                else
                {
                        //Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
                        if(!$user->userCakeAddUser('chef'))
                        {
                                if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
                                if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
                        }
                }
        }
        if(count($errors) == 0) {
                $successes[] = $user->success;
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
                <div class='col-md-6' style='margin-bottom: 50px;'>
                    <div class='col-md-12 header header-large' style='margin-top: 20px;'>Create Chef Profile</div>
                    <div class='col-md-12'><p><i>A Chef Account is used to <strong>teach</strong> cooking classes to students.</i></p>
                    <p><strong>How It Works</strong>:
                      <ul>
                          <li>Piq is an online marketplace to sell your cooking classes</li>
                          <li>You design the class, decide the price, select the location, etc.</li>
                          <li>Most of our chefs host classes in their homes</li>
                          <li>Payments from students will be sent to you via Email Transfer within 24 hours of the class</li>
                          <li>Classes are free to list; Piq takes a 10% commission on class sales only</li>
                      </ul>
                    </p>
                    </div>

                    <div class='col-md-12' style='margin-top: 15px;'><p><i>Want to <strong>take</strong> cooking classes? <a href='register.php'>Register as a Student</a>.</i></p></div>
                    <!-- <div class='col-md-12 bg-danger' style='margin-top: 15px; padding-top: 10px;'></div> -->
		    <?= resultBlock($errors,$successes); ?>
                    <div class='col-md-12' style='margin-top: 20px;'>
			<form name='newUser' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input type="text" class="form-control" name='displayname' id="username" placeholder="Jackie Smith">
                      </div>
		      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Jackie.Smith@Domain.com">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" id="pass" name="password" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmpass" name="passwordc" placeholder="Confirm Password">
                      </div>
                      <div class="form-group">
			<label>Security Code:</label>
			<img src='models/captcha.php'>
			<br/>
			<label>Enter Security Code:</label>
			<input name='captcha' type='text'>
                      </div>
                      <button type="submit" class="btn btn-default">Create Account</button>
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
