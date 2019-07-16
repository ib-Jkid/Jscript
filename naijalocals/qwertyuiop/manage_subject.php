<?php ob_start(); //starting output buffering

//importing the function file where most of my functions are located
require("../functions.php");
require("../session.php");
if (cleared(4)) {

	include("header.php");
//connecting to database by using a function created in the function file
$connection = connect_DB();

?>

<?php 
//checking to see if the username field in the form is set and also if the action is to create
if (isset($_POST['delete'])) {
$id = $_POST['subject'];
$query = "Delete from navigations where id = {$id}";
$result = get_result($query);
mysqli_free_result($result);
	
}
$query = "select * from navigations";
$result = get_result($query);

?>




<?php 
//checking to see if the username field in the form is set and also if the action is to create
if (isset($_POST['submit']) && $_POST['name']==!NULL) {
	//using mysqli real ecsape string to clean the input from special char
	$name = mysqli_real_escape_string($connection, $_POST['name']);
	$link = mysqli_real_escape_string($connection, $_POST['link']);
	$visibility = $_POST['visibility'];
	$query = "insert into navigations (name,link,visibility)";
	$query .= "values ('{$name}','{$link}',	{$visibility})";
	//getting result from DB
	$result = get_result($query);
        //freeing up the result
	if($result) {echo "successfull";}
	mysqli_free_result($result);
}

?>

<!--this forms allows you to create new tabs in the navigation-->
 <form class="form1" action="create_subject.php" method="post">
<h1>Create New Subject</h1>
	name:<input type="text" name="name" placeholder="eg home"/><br />
	link:<input type="text" name="link" placeholder="eg home.php"/><br />
	visibility: <select name="visibility">
		<option value="0">0</option>
		<option value="1">1</option></select><br />
        <input type="submit" name="submit" value="create"/>
</form>

<!--this forms allows you to delete tabs in the navigation-->
 <form class="form1" action="create_subject.php" method="post">
	<h1>Delete Subject</h1>
	Subjects: <select name="subject"><br />
		<option value="subject">subject</option>
		<?php
			while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='".$row['id']."'>".$row['name']."</option>";
			}
		?>
		</select><br />
		<input type="submit" name="delete" value="delete"/>
		<input type="submit" name="edit" value="edit"/><br />
	<a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>
</form>


<?php 
if(isset($_GET['action']) && isset($_GET['id'])) {
	$id = $_GET['id'];
	/*surounding with try catch block to prevent 
	errors is file not found or cant be deleted for 
	some reason*/
	try {
		/****************
		 * 
		 * trying code bellow to delete with file
		 * the code works yea!!!!
		 */
		$query = "select link from slide where id = {$id}";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		$piclink = "../".$row['link'];
		unlink($piclink);
		///////////////////////////////////
	} catch (Exception $e) {

	}
	$query = "delete from slide where id = {$id}";
	$result = get_result($query);
}
if(isset($_POST['upload'])) {
	if($_FILES['picture']['error'] == 0) {
		$imageFileType = $_FILES['picture']['type'];
			if ($imageFileType == "image/jpeg" || $imageFileType == "image/gif" || $imageFileType == "image/png") {
			$picture_location = "../images/slides/".$_FILES['picture']['name'];	
				if(move_uploaded_file($_FILES['picture']['tmp_name'],$picture_location)) {
					$name = mysqli_real_escape_string($connection,$_POST['name']);
					$caption = mysqli_real_escape_string($connection,$_POST['caption']);
					$link = mysqli_real_escape_string($connection,"images/slides/".$_FILES['picture']['name']);
					$query = "insert into slide (name,caption,link) ";
					$query .= "values ('{$name}','{$caption}','{$link}')";
					$result = get_result($query);
				}
			}else {
				echo "upload image file";
				echo $imageFileType;
			}

	}else {
		echo "error in file";
	}
}
$query = "select * from slide";
$result = get_result($query);
?>
<div>
	<?php while($row = mysqli_fetch_assoc($result)) {?>
		<div class="home-slides">
			<img src="<?php echo "../".$row['link']?>" /><br />
			<a href="manage_subject.php?action=delete&id=<?php echo $row['id'];?>" >DELETE</a><br />
		</div>
	<?php }?>
	<form action="manage_subject.php" method="post" enctype="multipart/form-data">
		<input type="text" name="name" placeholder="picture name"/><br />
		<input type="text" name="caption" placeholder="caption"/><br />
		picture: <input type="file" name="picture" /><br />
		<input type="submit" value="upload" name="upload" />
	</form>
</div>

<?php
mysqli_close($connection);
include("footer.php");
} else {header("LOCATION: alogin.php");}
?>
