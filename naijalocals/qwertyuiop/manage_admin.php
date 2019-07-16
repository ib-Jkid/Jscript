<?php ob_start();
require("../functions.php");
require("../session.php");
$connection = connect_DB();
if(cleared(4)) {
	include("header.php");
	if(isset($_POST['submit_create'])) {
		$username = mysqli_real_escape_string($connection,$_POST['username']);
		$password = $_POST['password'];
		$level = $_POST['level'];
		$access = $_POST['level'];
		$hash = hash_password($username,$password);
		$query = "insert into admins (username, password, level, access ) ";
		$query .= "values ('{$username}', '{$hash}', {$level}, {$access} )";
		if($result = get_result($query)) {echo "successful".$username;}
	}
	if(isset($_POST['submit_delete'])) {
		$id = $_POST['admin']; 
		$query .= "delete from admins where id = {$id}";
		if($result = get_result($query)) {echo "successful";}
	}
  	

?>
<form action="manage_admin.php" method="post">
	USERNAME: <input type="text" name="username" placeholder="username" required /><br />
	PASSWORD: <input type="password" name="password" placeholder="password" required /><br />
	LEVEL: <select name="level"><option value="1">1</option><option value="2">2</option>
	<option value="3">3</option></select><br />
	ACCESS: <select name="access"><option value="1">1</option><option value="0">0</option>
	</select><br />
	<input type="submit" name="submit_create" value="create"/>
</form>

<?php
	$query = "select * from admins";
	$result = get_result($query);
?>

<form action = "manage_admin.php" method="post" >
	<select name="admin">
		<?php 
			while($row = mysqli_fetch_assoc($result)) {
			echo "<option value= '".$row['id']."'>".$row['username']."</option>";
			}
		?>
	</select>
	<input type="submit" name="submit_delete" />

</form>
<br /><a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>
<?php

mysqli_close($connection);
include("footer.php");
}else {header("LOCATION: alogin.php");}
?>
