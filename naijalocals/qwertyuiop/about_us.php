<?php ob_start();
require("../functions.php");
require("../session.php");
$connection = connect_DB();
/*************************************************************
the shitty looking code bellow grabs info from the form in this
page and update the about_us table in the database.
the cleared function checks to see if the currect user have the
required permission to perform any action on this page

**************************************************************/
if(cleared(4)) {
include("header.php");
	if(isset($_POST['submit']) && $_POST['email'] != NULL) {
		$email = mysqli_real_escape_string($connection,$_POST['email']);
		$twitter = mysqli_real_escape_string($connection,$_POST['twitter']);
		$instagram = mysqli_real_escape_string($connection,$_POST['instagram']);
		$facebook = mysqli_real_escape_string($connection,$_POST['facebook']);
		$vision = mysqli_real_escape_string($connection,$_POST['vision']);
		$query2 = "update about_us set email = '{$email}', ";
		$query2 .= "twitter = '{$twitter}', ";
		$query2 .= "instagram = '{$instagram}', ";
		$query2 .= "facebook = '{$facebook}', ";
		$query2 .= "vision = '{$vision}' ";
		$query2 .= "where id = 1";
		if ($result = get_result($query2)) {echo "successfull";}

	}
	$query = "select * from about_us";
	$result = get_result($query);
	$row = mysqli_fetch_assoc($result);
	
	
  	
/*************************************************************




**************************************************************/
?>
<!-------------------------------------------------------------
after avoiding it for so long i decided to use html comment here
and i must say it is so stressfull compared to this /*  */ just
want to let u know that the above SQL syntax result is used to
populate the values of the form bellow so as to display on the 
page for editing!!!

-------------------------------------------------------------->
<form action="about_us.php" method="post" >
	Email: <input type="email" name = "email" value="<?php echo $row['email'] ?>" /><br />
	Twitter: <input type="text" name = "twitter" value="<?php echo $row['twitter'] ?>" /><br />
	Instagram: <input type="text" name = "instagram" value="<?php echo $row['instagram'] ?>" /><br />
	Facebook: <input type="text" name = "facebook" value="<?php echo $row['facebook'] ?>" /><br />
	Vision: <textarea name="vision"><?php echo $row['vision'] ?></textarea><br />
	<input type="submit" name="submit" value="submit" />
	
</form>

<?php 
if(isset($_GET['action']) && $_GET['action'] == "delete") {
	if($id = $_GET['id']) {
		$query = "delete from feedbacks where id ={$id}";
		if($result = get_result($query)) {echo "deleted!!";}
	} 
}

$query = "select * from feedbacks order by id desc";
$result = get_result($query);
?>
<table border="5px">
		<th>
			<td colspan="4" align="center">ARTICLE</td>

		</th>
		<tr>
			<td>ID</td>
			<td>NAME</td>
			<td>EMAIL</td>
			<td>MESSAGE</td>
			<td>ACTION</td>

		</tr>
	<?php while($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php echo $row['id'];?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo $row['email'];?></td>
			<td><?php echo $row['message'];?></td>
			<td><a href="about_us.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
		</tr>
	<?php } ?>
	</table>


<?php

mysqli_close($connection);
include("footer.php");
}else {header("LOCATION: alogin.php");}
?>
