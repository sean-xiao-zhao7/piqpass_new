<?php
	require_once("models/config.php");
	require_once("db/connect.php");
	$result = $mysqli_piq->query("select * from class where approval = 'approved' order by id desc limit 8");
	$classes = [];
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$classes[] = $row;
	}
	$result->close();
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Toronto Cooking Classes | Piq</title>
        <meta name="description" content="Piq is a social marketplace to take cooking classes from your neighbours. Experience where the people in your city come from, how they lived their lives, and the type of people they are through the dishes they pass onto you.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@piq_toronto" />
        <meta name="twitter:title" content="Piq" />
        <meta name="twitter:description" content="Piq is a social marketplace to take cooking classes from your neighbours. Experience where the people in your city come from and how they lived their lives through the dishes they pass onto you." />

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
				<link rel="stylesheet" href="css/style_new.css">

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800' rel='stylesheet' type='text/css'>
        <script src="//load.sumome.com/" data-sumo-site-id="5e445f80d3e8e136270db5056c7a69fd73be6ee2dc7d167cd25ad34e2dc09fe1" async="async"></script>
    </head>
    <body>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=377900289009078";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class='row' style='width: 100%;'>
					<div class='col-md-12 main-bg'>
							<div class='col-md-12'>
								<div class='col-md-3 nav-top nav-left' align='center'><img src='img/logo_transparent.png' /></div>
								<!-- Desktop Nav -->
								<div class='col-md-9 desktop'>
										<div class='col-md-6 nav-top-text'><span class='nav'><a href='#story'>Our Story</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href='#benefits'>Benefits</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href='browse.php'>Classes</a></span></div>
										<div class='col-md-3 nav-top-text' style='float: right; margin-right: 0px;'><span class='nav'><a href='login.php' class='button-border'>Login</a></span></div>
								</div>
								<!-- Mobile Nav -->
								<div class='col-md-9 mobile'>
											<!--Account-->
											<div class='dropdown row-center' align='center' style='padding-top: 20px;'>
												<button class='btn btn-default btn-sm dropdown-toggle' type='button' id='mode' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
													Menu
													<span class='caret'></span>
												</button>
												<ul class='dropdown-menu' aria-labelledby='mode'>
												  <li><a href='#story' ><span style='color: #000;'>Our Story</span></a></li>
													<li><a href='#benefits'><span style='color: #000;'>Benefits</span></a></li>
													<li><a href='#contact'><span style='color: #000;'>Contact</span></a></li>
													<li role='separator' class='divider'></li>
													<li><a href='login.php'><span style='color: #000;'>Login</span></a></li>
													<li><a href='register.php'><span style='color: #000;'>Student Registration</span></a></li>
													<li><a href='register_chef.php'><span style='color: #000;'>Chef Registration</span></a></li>
												</ul>
											</div>

								</div>

							</div>
							<div class='col-md-12 header-margin'>
									<div class='col-md-12 large-heading'><center><i><u>Social</u></i> Cooking Classes.</center></div>
									<div class='col-md-12 small-heading'><center>Meet New People, Share Life Stories.</center></div>
									<div class='col-md-12 desktop' style='margin-top: 50px;'><center><a href='browse.php' class='button-border'>I Want To <strong><i>Take</i></strong> Classes</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='register_chef.php' class='button-border'>I Want To <strong><i>Teach</i></strong> Classes</a></center></div>
									<div class='col-md-12 mobile' style='margin-top: 50px;'><center><a href='browse.php' class='button-border'>I Want To <strong><i>Take</i></strong> Classes</a><br /><br /><a href='register_chef.php' class='button-border'>I Want To <strong><i>Teach</i></strong> Classes</a></center></div>
									<div class='col-md-12' style='margin-top: 70px; margin-left: 5px;'><center><span style='color: #FFF; font-size: 5vw;' class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></center></div>
							</div>
					</div>

					<div class='col-md-12' style='margin-bottom: 50px;'>
							<div class='col-md-12 title' style='margin-top: 40px;'><center><p>Featured Class</p></center></div>
							<div class='col-md-12'>
									<p class='center-p' align='center'>Piq runs a several promotions every week; come check us out tomorrow! Subscribe in the bar above to get notified on latest promotions :)</p>
							</div>
					</div>

					<!--Class 1-->
					<div class='col-md-6 class1-bg'>
							<div class='col-md-12' style='top: 35%;'><span class='class-title'><center>The Art of Indian Cooking</center></span></div>
					</div>
					<div class='col-md-6 class-height'>
							<div class='col-md-12' style='margin-top: 40px;'>
									<p class='center-p'>
											<strong>Instructor:</strong> Chef Dimple Mehta of Healthy Bellee<br />
											<strong>Location:</strong> Home kitchen of Chef Dimple (Etobicoke, Toronto)<br />
											<strong>Address:</strong> Exact address will only be sent to registered guests<br />
											<strong>Seats:</strong> 6 seats available<br />
											<strong>Price:</strong> <strike>$60.50</strike> <span style='color: #ff0000;'>$54.00</span> / person<br /><br />
											<a href='http://trypiq.com/class_stripe.php?class_id=52' class='btn btn-md btn-success'><span style='color: #fff;'>View Class</span></a>
									</p>
							</div>
					</div>

					<div class='col-md-12' style='margin-bottom: 50px;'>
							<div class='col-md-12' style='margin-top: 40px;'><span class='title'><center>Follow Piq on Facebook</center></span></div>
							<div class='col-md-12' align='center' style='margin-top: 20px;'>
	              <div class="fb-like" align='center' style='width: 100%; overflow: hidden;' data-href="https://www.facebook.com/trypiq" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
	            </div>
					</div>

					<div class='col-md-6 story-bg' id='story'>&nbsp;</div>
					<div class='col-md-6 story-text'>
							<div class='col-md-12 story-top'><span class='title'><center>Our Story</center></span></div>
							<div class='col-md-12' style='margin-top: 35px;'>
									<p class='center-p'>Piq is a social marketplace for cooking classes, which allow professional chefs and hobbyists share their knowledge to those around them. The idea of Piq is grounded in connections. Each individual in every community has a story...a story that reflects their past…a story that is reflected in the meals they create. Whether they are great chefs or not, there is history and meaning their culinary creations. Wouldn’t it be interesting to connect with those in your community? Or those in communities you visit? Or those from your homeland? We definitely think so.</p>
							</div>
					</div>

					<div class='col-md-6 benefits-bg mobile'>&nbsp;</div>
					<div id='benefits' class='col-md-6 benefits-text'>
							<div class='col-md-12 benefits-top'><span class='title'><center>Benefits</center></span></div>
							<div class='col-md-12' style='margin-top: 25px;'>

									<p class='center-p'>
											<strong>1. Dating, Anniversaries, or Special Occasions:</strong> What a memorable way to enjoy a morning or afternoon spicing up interesting and exotic dishes in a cooking class! We have many classes at different prices making it appropriate for a first date or a 5 year anniversary!<br />
											<strong>2. Social Activity with Friends:</strong> Why do the same thing every week? Change up the routine and explore!<br />
											<strong>3. Meet &amp; Connect with New People:</strong> The classes are typically small sized between 4-6 people in an intimate setting.<br />
											<strong>4. Team Building:</strong> Cooking classes are a great option for team building through collaborating the meal prep and feasting on the finished results.<br />
											<strong>5. An Experience:</strong> End of the day, classes offered on Piq are experiences. Meeting new people, trying new food, and sharing stories is an experience that is difficult to find elsewhere.
									</p>
							</div>
					</div>
					<div class='col-md-6 benefits-bg desktop'>&nbsp;</div>
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
