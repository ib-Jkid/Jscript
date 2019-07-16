<?php ob_start();
require("session.php");
require("functions.php");
$connection = connect_DB();
include("header.php");
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
	$username = mysqli_real_escape_string($connection,$_POST['username']);
	$password = $_POST['password'];
	$failed = false;
	$hashed_password = hash_password($username,$password);
	$query = "select * from users where username = '{$username}'";
	if($result = get_result($query)) {
		$row = mysqli_fetch_assoc($result);
		if($row['password'] === $hashed_password) {
			/************************
			 * creating a session for the user
			 */
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['logged_in'] = true;
			/****************
			 * 
			 * update the login date from the database
			 */
			$id = $row['id'];
			$time = time();
			$query = "update users set last_visit = '{$time}' where id = {$id}";
			$result = get_result($query);
			header("Location: index.php");
			exit;
			
			
		}else {
			$failed = true;
		}

	}else {
		$failed = true;
	}
	if($failed) {echo "<i>username or password incorrect</i>";}

}
?>
<style>
	.aside {
		display: none;
	}
</style>


		<div class="sign_up">
			<form action="login.php" method="post">
				USERNAME: <input type="text" name="username" placeholder="username" required/><br />
				PASSWORD: <input type="password" name="password" placeholder="password" required /><br />
				<input type="submit" name="submit" value="login"/>
			</form>
			<p>
				new here?	<a href="sign_up.php">sign up</a>
			</p>
		</div>

	
<?php
include("footer.php");
mysqli_close($connection);

?>
