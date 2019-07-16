<?php ob_start();
require("../session.php");
require("../functions.php");
$connection = connect_DB();
/*************************************************************
Finally the much written alogin page!!!!
this if statement bellow takes the users login details and compares 
it with those on the database table admins.
	if a match is found it creates some variables to the session
started in the ../session.php file required above. 



**************************************************************/
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
	$username = mysqli_real_escape_string($connection,$_POST['username']);
	$password = $_POST['password'];
	$failed = false;
	$hashed_password = hash_password($username,$password);
	$query = "select * from admins where username = '{$username}'";
	if($result = get_result($query)) {
		$row = mysqli_fetch_assoc($result);
		if($row['password'] === $hashed_password && $row['access'] != NULL) {
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['level'] = $row['level'];
			$_SESSION['logged_in'] = true;
			header("Location: index.php");
			exit;
			
			
		}else {
			$failed = true;
		}

	}else {
		$failed = true;
	}
	

}
?>
<!--------------------------the login form ------------------------------>
<form action="alogin.php" method="post">
	USERNAME: <input type="text" name="username" placeholder="username" required/><br />
	PASSWORD: <input type="password" name="password" placeholder="password" required /><br />
	<input type="submit" name="submit" value="login"/>
</form>
<link href="ad.css" type="text/css" rel="stylesheet"/>
<?php
mysqli_close($connection);
?>
