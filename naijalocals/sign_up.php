<?php ob_start();
require("session.php");
require("functions.php");

$connection = connect_DB();
include("header.php");
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
	$username = mysqli_real_escape_string($connection,$_POST['username']);
	$first_name = mysqli_real_escape_string($connection,$_POST['first_name']);
	$last_name = mysqli_real_escape_string($connection,$_POST['last_name']);
	$email = mysqli_real_escape_string($connection,$_POST['email']);
	$password = $_POST['password'];
	$hashed_password = hash_password($username,$password);
	$query = "select * from users where username = '{$username}'";
	$result = get_result($query);
	if(!($row = mysqli_fetch_assoc($result))) {
	 
		$query = "insert into users (first_name, last_name, email, password, username) ";
		$query .= "values ('{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', '{$username}')";
		$result = get_result($query);
		mysqli_free_result($result);
		$_SESSION['username'] = $username;
		$_SESSION['logged_in'] = true;
			/****************
			 * 
			 * update the login date from the database
			 */
			$id = $row['id'];
			$time = time();
			$query = "update users set last_visit = '{$time}' where username = '{$username}'";
			$result = get_result($query);
		header("Location: index.php");
		exit;
				
	} else {echo "username already exists";
		mysqli_free_result($result);		
		}

}
?>
<style>
	.aside {
		display: none;
	}
</style>

				
		<div class="sign_up">
			<form action="sign_up.php" method="post">
				<p>USERNAME: <input type="text" name="username" placeholder="username" required/></p>
				<p>FIRST NAME: <input type="text" name="first_name" placeholder="eg John" required/></p>
				<p>LAST NAME: <input type="text" name="last_name" placeholder="eg Isah" required/></p>
				<p>EMAIL: <input type="text" name="email" placeholder="eg example@mail.com" required/></p>
				<p>PASSWORD: <input type="password" name="password" placeholder="password" required /></p>
				<input type="submit" name="submit" value="sign up"/>
			</form>
		</div>
	
<?php
include("footer.php");
mysqli_close($connection);

?>
