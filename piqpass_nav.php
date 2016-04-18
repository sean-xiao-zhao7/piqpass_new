<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	 <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='dashboard.php'>Dashboard</a></div>
	 <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='user_settings.php'>User Settings</a></div>
	 <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='logout.php'>Logout</a></div>";
	if ($loggedInUser->checkPermission(array(3))){
                //echo "I'm chef";
                echo
                "<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='add_class.php'>Add a class</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='class_dashboard.php'>Class Dashboard</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='sessions_dashboard.php'>Session Dashboard</a></div>
                <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='requests_dashboard.php'>Request Dashboard</a></div>";
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
			<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='login.php'>Login</a></div>
			<div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='register.php'>Register</a></div>
			
			                    <!--Classes-->
                    <div class='dropdown' style='float: right; margin-left: 8px;'><a class='btn btn-default btn-sm' href='browse.php'>Browse</a></div>
	";
}
?>
