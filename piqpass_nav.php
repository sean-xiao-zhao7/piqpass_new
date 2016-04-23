<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	if ($loggedInUser->checkPermission(array(3))){
		echo "<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='add_class.php'>Add a class</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='class_dashboard.php'>Class Dashboard</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='sessions_dashboard.php'>Session Dashboard</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='requests_dashboard.php'>Request Dashboard</a></div>
		<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='user_settings.php'>User Settings</a></div>
	        <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='logout.php'>Logout</a></div>";
        } else {
		echo "
		<div class='col-md-10 desktop' style='margin-top: 15px;'>
			<p align='right'>
				<!--Account-->
				<div class='dropdown' style='float: right; margin-left: 25px; margin-right: -15px;'>
					<button class='btn btn-default btn-sm dropdown-toggle' type='button' id='mode' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
						Account
						<span class='caret'></span>
					</button>
					<ul class='dropdown-menu' aria-labelledby='mode'>
						<li><a href='account.php'>Update Profile</a></li>
						<li><a href='update_password.php'>Change Password</a></li>
						<li role='separator' class='divider'></li>
						<li><a href='logout.php'>Logout</a></li>
					</ul>
				</div>
				<!--Classes-->
				<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm'>Browse</a></div>
				<!--dashboard-->
				<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm'>Dashboard</a></div>
				<!--Modes-->
				<div class='dropdown' style='float: right;'>
					<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='mode' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
						You Are In <strong>Chef Mode</strong>
						<span class='caret'></span>
					</button>
					<ul class='dropdown-menu' aria-labelledby='mode'>
						<li><a href='#'>Student Mode</a></li>
					</ul>
				</div>
		</p>
		</div>
		<div class='col-md-10 mobile' style='margin-top: 25px;'>
			<p align='left'>
				<!--Account-->
				<div class='dropdown' style='float: left; margin-left: 15px;'>
					<button class='btn btn-default btn-sm dropdown-toggle' type='button' id='mode' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
						Menu
						<span class='caret'></span>
					</button>
					<ul class='dropdown-menu' aria-labelledby='mode'>
						<li><a href='#'>Chef Mode</a></li>
						<li><a href='#'>Student Mode</a></li>
						<li role='separator' class='divider'></li>
						<li><a href='dashboard.php'>Dashboard</a></li>
						<li><a href='browse.php'>Browse</a></li>
						<li role='separator' class='divider'></li>
						<li><a href='account.php'>Update Profile</a></li>
						<li><a href='update_password.php'>Change Password</a></li>
						<li><a href='logout.php'>Logout</a></li>
					</ul>
				</div>
		</p>
		</div>";
	}
	//Links for permission level 2 (default admin)

	if ($loggedInUser->checkPermission(array(2))){
	echo "<ul>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li></ul>";
	}

}
//Links for users not logged in
else {
	echo "
	<!--Account-->
	<div class='col-md-10 desktop neg-15' style='margin-top: 15px;'>
		<p align='right'>
			<!--dashboard-->
			<div class='dropdown' style='float: right; margin-left: 8px;'><a href='login.php' class='btn btn-default btn-sm'>Login</a></div>
			<!--Classes-->
			<div class='dropdown' style='float: right; margin-left: 8px;'><a href='register.php' class='btn btn-success btn-sm'><strong>Register</strong></a></div>
			</p>
	</div>
	<div class='col-md-10 mobile' style='margin-top: 25px;'>
		<p align='left'>
			<!--Account-->
			<div class='dropdown' style='float: left; margin-left: 15px;'>
				<button class='btn btn-default btn-sm dropdown-toggle' type='button' id='mode' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
					Menu
					<span class='caret'></span>
				</button>
				<ul class='dropdown-menu' aria-labelledby='mode'>
					<li><a href='#'>Chef Mode</a></li>
					<li><a href='#'>Student Mode</a></li>
					<li role='separator' class='divider'></li>
					<li><a href='dashboard.php'>Dashboard</a></li>
					<li><a href='browse.php'>Browse</a></li>
					<li role='separator' class='divider'></li>
					<li><a href='account.php'>Update Profile</a></li>
					<li><a href='update_password.php'>Change Password</a></li>
					<li><a href='logout.php'>Logout</a></li>
				</ul>
			</div>
	</p>
	</div>
	";
}
?>
