<?php ob_start();
require("../functions.php");
require("../session.php");
if (cleared(4)) {
	include("header.php");
$connection = connect_DB();
/*********************************************
this bunch of code bellow 
edits the article on the database 
it collects its info from a post request
sent by a form on this same page ***



***************************************************/
if(isset($_POST['submit']) && $_POST['title'] != NULL) {
	$id = $_POST['id'];
	$title = mysqli_real_escape_string($connection,$_POST['title']);
	$type = mysqli_real_escape_string($connection,$_POST['type']);
	$author_name = mysqli_real_escape_string($connection,$_POST['author_name']);
	$visibility = $_POST['visibility'];
	$article = mysqli_real_escape_string($connection,$_POST['article']);
	$link = mysqli_real_escape_string($connection,$_POST['ilink']);
	$time = time();
	$query = "update story";
	$query .= " set title = '{$title}', author_name = '{$author_name}', date = '{$time}', type = '{$type}', visibility = {$visibility}, ";
	$query .= "article = '{$article}', picture_link = '{$link}' where id = {$id}";
	
	if($result = get_result($query)) {echo "successfull";}else {echo "failed";}

}

?>


<?php 
/*******************************************************
the folowing code takes data from the SQL table and displays
on the html table.. in short we tabled the matter!!!

********************************************************/
if(!isset($_GET['action'])) {
	/*************************
	 * the story about the codes below part 1
	 * the php and html code below simply provides a search form for 
	 * ease in selecting files in the future incase they get much.
	 */
	/*this if statement bellow checks if there was a search done through a 
	 *post request submited by this page to itself and changes to sql query 
	 *to work accordinly
	 */
	if(isset($_POST['s'])) {
		$s = mysqli_real_escape_string($connection,$_POST['s']);
		$query = "select * from story where title like '%{$s}%' order by id desc"; 
	}
	else {
		$query = "select * from story order by id desc";
	}
$result = get_result($query);
?>
<!---------------------------------
this is the search form
---------------------------------------->
<form method="post" action="edit_article.php" >
	<input type="text" name="s" />
	<input type="submit" value="search"/>
</form>
<a href="edit_article.php" >Show all</a>


<table border="5px">
		<th>
			<td colspan="8" align="center">ARTICLE</td>

		</th>
		<tr>
			<td>ID</td>
			<td>TITLE</td>
			<td>AUTHOR NAME</td>
			<td>LIKES</td>
			<td>DISLIKES</td>
			<td>DATE</td>
			<td>TYPE</td>
			<td colspan = "2">ACTION</td>

		</tr>
	<?php while($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php echo $row['id'];?></td>
			<td><?php echo $row['title'];?></td>
			<td><?php echo $row['author_name'];?></td>
			<td><?php echo $row['likes'];?></td>
			<td><?php echo $row['dislikes'];?></td>
			<td><?php echo date('d',$row['date'])."-".date('M',$row['date'])."-".date('Y',$row['date']);?></td>
			<td><?php echo $row['type'];?></td>
			<td><a href="edit_article.php?id=<?php echo $row['id'];?>&action=edit">edit</a></td>
			<td><a href="edit_article.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
		</tr>
	<?php } ?>
	</table>
	<?php } ?>

<?php 
/***********************************
the code below checks if the get request
sent is to edit it then takes the id
sent via the get request and populate the 
form with info relating to that id
***********************************/
if($_GET['action'] == 'edit') { 
	$id = $_GET['id'];
	$query = "select * from story where id = {$id}";
	$result = get_result($query);
	$row = mysqli_fetch_assoc($result);

?>
<form action="edit_article.php" method = "post">
		<input type="hidden" name = "id" value="<?php echo $id; ?>" />
		Title: <input type="text" name="title" value="<?php echo $row['title']; ?>"/><br />
		Type: <input type="text" name="type" value="<?php echo $row['type']; ?>"/><br />
		Author Name: <input type="text" name="author_name" value="<?php echo $row['author_name']; ?>"/><br />
		visibility: <select name="visibility">
				<option value="1">YES</option>
				<option value="0">NO</option>
			</select><br />
		Article : <textarea name="article" ><?php echo $row['article']; ?></textarea><br />
		Image_link : <input type="text" name="ilink" value="<?php echo $row['picture_link']; ?>"/><br />
		

<input type="submit" name="submit" value="upload"/>

</form>
<?php } ?>
<!------------------------------
this deletes shit

------------------------------->
<?php if($_GET['action'] == 'delete' ) { 
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
		$query = "select picture_link from story where id = {$id}";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		$piclink = "../".$row['picture_link'];
		unlink($piclink);
		///////////////////////////////////
	}catch (Exception $e) {
		
	}
	$query = "delete from story where id = {$id}";
	$result = get_result($query);
	echo 'deleted';
	header("LOCATION: edit_article.php");
}

?>
<a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>
<?php
mysqli_close($connection);
include("footer.php");
} else {header("LOCATION: alogin.php");}
?>
