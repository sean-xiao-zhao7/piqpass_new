<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{
        $errors = array();
        $successes = array();
        $password = $_POST["password"];
        $password_new = $_POST["passwordc"];
        $password_confirm = $_POST["passwordcheck"];

        $errors = array();
        $email = $_POST["email"];

        //Perform some validation
        //Feel free to edit / change as required

        //Confirm the hashes match before updating a users password
        $entered_pass = generateHash($password,$loggedInUser->hash_pw);

	if (trim($password) == ""){
                $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
        }
        else if($entered_pass != $loggedInUser->hash_pw)
        {
                //No match
                $errors[] = lang("ACCOUNT_PASSWORD_INVALID");
        }
        if($email != $loggedInUser->email)
        {
                if(trim($email) == "")
                {
                        $errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
                }
                else if(!isValidEmail($email))
                {
                        $errors[] = lang("ACCOUNT_INVALID_EMAIL");
                }
                else if(emailExists($email))
                {
                        $errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));
                }

                //End data validation
                if(count($errors) == 0)
                {
                        $loggedInUser->updateEmail($email);
                        $successes[] = lang("ACCOUNT_EMAIL_UPDATED");
                }
        }
	
	if ($password_new != "" OR $password_confirm != "")
        {
                if(trim($password_new) == "")
                {
                        $errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
                }
                else if(trim($password_confirm) == "")
                {
                        $errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
                }
                else if(minMaxRange(8,50,$password_new))
                {
                        $errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
                }
                else if($password_new != $password_confirm)
                {
                        $errors[] = lang("ACCOUNT_PASS_MISMATCH");
                }

                //End data validation
                if(count($errors) == 0)
                {
                        //Also prevent updating if someone attempts to update with the same password
                        $entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);

                        if($entered_pass_new == $loggedInUser->hash_pw)
                        {
                                //Don't update, this fool is trying to update with the same password Â¬Â¬
                                $errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
                        }
                        else
                        {
                                //This function will create the new hash and update the hash_pw property.
                                $loggedInUser->updatePassword($password_new);
                                $successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
                        }
                }
        }
        if(count($errors) == 0 AND count($successes) == 0){
                $errors[] = lang("NOTHING_TO_UPDATE");
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
			          <?= include("piqpass_nav.php"); ?>
            </div>
            <!--end header-->
            <!--body-->
            <div class='col-md-12 neg-15' style='margin-top: 40px;'>
                <div class='col-md-6' style='margin-bottom: 50px;'>
                    <div class='col-md-12 header header-large' style='margin-top: 20px;'>Create Student Profile</div>
                    <!-- <div class='col-md-12 bg-danger' style='margin-top: 15px; padding-top: 10px;'></div> -->
		    <?= resultBlock($errors,$successes); ?>
                    <div class='col-md-12' style='margin-top: 20px;'>

			<form name='updateAccount' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
			<div class="form-group">
			<label>Password:</label>
			<input type='password' name='password' />
			</div>
			<div class="form-group">
			<label>Email:</label>
			<input type='text' name='email' value='<?= $loggedInUser->email ?>' />
			</div>
                        <div class="form-group">
			<label>New Pass:</label>
			<input type='password' name='passwordc' />
			</div>
                        <div class="form-group">
			<label>Confirm Pass:</label>
			<input type='password' name='passwordcheck' />
			</div>
                        <div class="form-group">
			<label>&nbsp;</label>
			<input type='submit' value='Update' class='submit' />
			</div>
			</form>
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
