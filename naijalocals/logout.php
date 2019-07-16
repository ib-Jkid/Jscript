<?php ob_start(); //starting output buffering
require("session.php");

//importing the function file where most of my functions are located
require("functions.php");
if($_POST['logout']) {
	session_destroy();
	header("Location: index.php");
	exit;
	

}


//connecting to database by using a function created in the function file





?>
