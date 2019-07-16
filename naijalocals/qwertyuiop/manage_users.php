<?php ob_start();
require("../functions.php");
require("../session.php");
$connection = connect_DB();
if(cleared(4)) {
	include("header.php");
/*********************************************************************

*********************************************************************/
	if (isset($_POST['edit_user'])) {
		$id = $_POST['id'];
		$first_name = mysqli_real_escape_string($connection,$_POST['first_name']);
		$last_name = mysqli_real_escape_string($connection,$_POST['last_name']);
		$email = mysqli_real_escape_string($connection,$_POST['email']);
		$username = mysqli_real_escape_string($connection,$_POST['username']);
		$query = "update users set first_name = '{$first_name}', last_name = '{$last_name}', email = '{$email}', ";
		$query .= "username = '{$username}' where id = {$id}";	
		$result = get_result($query);
		mysqli_free_result($result);	


	}
	$query = "select * from users order by last_visit desc";
	$result = get_result($query);
	if(isset($_GET['id']) && isset($_GET['action'])) {
		if($_GET['action'] == 'edit') {
			$id = $_GET['id'];
			while($row = mysqli_fetch_assoc($result)) {
				if($row['id'] == $id) { ?>
				<form action="manage_users.php" method="post" >
					<input type="hidden" name="id" value = "<?php echo $row['id']; ?>" />
					First Name<input type="text" name = "first_name" value = "<?php echo $row['first_name']; ?>" />
					Last Name<input type="text" name = "last_name" value = "<?php echo $row['last_name']; ?>" />
					Email<input type="text" name = "email" value = "<?php echo $row['email']; ?>" />
					Username<input type="text" name = "username" value = "<?php echo $row['username']; ?>" />
					<input type="submit" name="edit_user" value="edit" />
				</form>
				<?php } 
			}

		}elseif($_GET['action'] == 'delete') {
			$id = $_GET['id'];
			$query2 = "delete from users where id = {$id}";
			$result2 = get_result($query2);
			echo "deleted";
			header("Location: manage_users.php");

		}

	}
	

	
	
?>
<p>Today's date: <?php echo date("d",time())."-".date("F",time())."-".date("Y",time())?></p>
	<table border="5px">
		<th>
			<td colspan="7" align="center">USERS</td>

		</th>
		<tr>
			<td>ID</td>
			<td>USERNAME</td>
			<td>FIRST NAME</td>
			<td>LAST NAME</td>
			<td>EMAIL</td>
			<td>LAST VISIT</td>
			<td colspan = "2">ACTION</td>

		</tr>
	<?php while($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php echo $row['id'];?></td>
			<td><?php echo $row['username'];?></td>
			<td><?php echo $row['first_name'];?></td>
			<td><?php echo $row['last_name'];?></td>
			<td><?php echo $row['email'];?></td>
			<td><?php echo date("d",$row['last_visit'])."-".date("F",$row['last_visit'])."-".date("Y",$row['last_visit']);?></td>
			<td><a href="manage_users.php?id=<?php echo $row['id'];?>&action=edit">edit</a></td>
			<td><a href="manage_users.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
		</tr>
	<?php } ?>
	</table>

<br /><a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>
<?php

mysqli_close($connection);
include("footer.php");
}else {header("Location: alogin.php");}
?>
