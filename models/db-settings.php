<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

//Database Information
$db_host = "db.piqpass.com"; //Host address (most likely localhost)
$db_name = "user_cake"; //Name of Database
$db_user = "cake_user"; //Name of database user
$db_pass = "BoxOfKittens2016"; //Password for database user
$db_table_prefix = "";

$db_host_piq = "db.piqpass.com"; //Host address (most likely localhost)
$db_name_piq = "piqpass_new"; //Name of Database
$db_user_piq = "cake_user"; //Name of database user
$db_pass_piq = "BoxOfKittens2016"; //Password for database user

GLOBAL $errors;
GLOBAL $successes;
GLOBAL $errors_piq;
GLOBAL $successes_piq;

$errors = array();
$errors_piq = array();
$successes = array();
$successes_piq = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>
