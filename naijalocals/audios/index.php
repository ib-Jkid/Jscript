<?php 
//making a database connection
function connect_DB() {
	//create a database connection
		$hostname = "localhost";
		$username = "street";
		$password = "qwertyuiop";
		$database = "naijanatives";
		$connect = mysqli_connect($hostname, $username, $password, $database);
		if (mysqli_connect_errno()) {
			die();
		}else {return $connect;}

}
//this function takes a password and username and returns a hash 
function hash_password($username,$password) {
	$salt = "pjhgrewetuhj".$username."iutrer".$username."yujjhhttr";
	$hash_format = "$2y$10$";
	$hash = crypt($password, $hash_format.$salt);
	return $hash;


}
//generates random id for the contents
function get_id($title) {
	return md5($title);

}
//this checks if logged in and clearance level is ok

function cleared ($level) {
	if($_SESSION['logged_in']) {
		if($_SESSION['level'] >= $level) {
			return true;
		}else {
			return false;
		}
	}else {
		return false;
	}

}

//this function checks if a username exists Not Working Yet
function check_username_admins ($username,$table) {
	$query = "select * from admins where username = '{$username}'";
	$result = mysqli_query($connection, $query);
	if (mysqli_fetch_assoc($result)) {
	$response = true;
	} else {
	$response = false; }
	mysqli_free_result($result);
	return $response; 

}
//this funtion gets result from database
function get_result($query) {
	global $connection;
 	$result = mysqli_query($connection,$query);
        //checking to see if the query was successfull
	if(!$result) {
	die("data query failed");
	}else 
	{return $result;}

}



?>