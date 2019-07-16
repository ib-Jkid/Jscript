<?php ob_start();
require("../functions.php");
require("../session.php");
if (cleared(4)) {
	include("header.php");
$connection = connect_DB();

/****************************************************
codes in this perform similar task to that of edit_musics
refer to its comment

*******************************************************/

if(isset($_POST['submit']) && $_POST['title']== !NULL) {
	$id = $_POST['id'];
	$title = mysqli_real_escape_string($connection,$_POST['title']);
	$artist = mysqli_real_escape_string($connection,$_POST['artist']);
	$language = mysqli_real_escape_string($connection,$_POST['language']);
	$year = $_POST['year'];
	$visibility = $_POST['visibility'];
	$type = mysqli_real_escape_string($connection,$_POST['type']);
	$mlink = mysqli_real_escape_string($connection,$_POST['mlink']);
	$plink = mysqli_real_escape_string($connection,$_POST['plink']);
	$article = mysqli_real_escape_string($connection,$_POST['article']);
	$query = "update videos set title = '{$title}', artist_name = '{$artist}', language = '{$language}', production_year = {$year}, type = '{$type}', visibility = {$visibility}, link = '{$mlink}', article = '{$article}', picture_link = '{$plink}' where id = {$id}";
	$result = get_result($query);
	mysqli_free_result($query);
	echo "successfull";
}


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
		$query = "select * from videos where title like '%{$s}%' order by id desc"; 
	}
	else {
		$query = "select * from videos order by id desc";
	}
$result = get_result($query);
?>
<!---------------------------------
this is the search form
---------------------------------------->
<form method="post" action="edit_videos.php" >
	<input type="text" name="s" />
	<input type="submit" value="search"/>
</form>
<a href="edit_videos.php" >Show all</a>
<!-------------------------------------------->
	<table border="5px">
		<th>
			<td colspan="10" align="center">VIDEOS</td>

		</th>
		<tr>
			<td>ID</td>
			<td>TITLE</td>
			<td>ARTIST NAME</td>
			<td>LANGUGE</td>
			<td>PRODUCTION YEAR</td>
			<td>TYPE</td>
			<td>LIKES</td>
			<td>DISLIKES</td>
			<td>DOWNLOADS</td>
			<td colspan = "2">ACTION</td>

		</tr>
	<?php while($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php echo $row['id'];?></td>
			<td><?php echo $row['title'];?></td>
			<td><?php echo $row['artist_name'];?></td>
			<td><?php echo $row['language'];?></td>
			<td><?php echo $row['production_year'];?></td>
			<td><?php echo $row['type'];?></td>
			<td><?php echo $row['likes'];?></td>
			<td><?php echo $row['dislikes'];?></td>
			<td><?php echo $row['downloads'];?></td>
			
			<td><a href="edit_videos.php?id=<?php echo $row['id'];?>&action=edit">edit</a></td>
			<td><a href="edit_videos.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
		</tr>
	<?php } ?>
	</table>

	<?php
}
?>
<?php if($_GET['action']== 'edit') { 
	$id = $_GET['id'];
	$query = "select * from videos where id = {$id}";
	$result = get_result($query);
	$row = mysqli_fetch_assoc($result);

?>
	<form action="edit_videos.php" method="post" >
	<input type="hidden" name = "id" value="<?php echo $id; ?>" />
	Title: <input type="text" name="title" value="<?php echo $row['title']; ?>"/><br />
	Artist Name: <input type="text" name="artist" value="<?php echo $row['artist_name']; ?>"/><br />
	Language: <input type="text" name="language" value="<?php echo $row['language']; ?>"/><br />
	Production-Year: <input type="number" name="year" min="2000" step="1" max="2099" 		value="<?php echo $row['production_year']; ?>"/><br />
	visibility: <select name="visibility">
		<option value="1">YES</option>
		<option value="0">NO</option></select><br />
	Type: <input type="text" name="type" value="<?php echo $row['type']; ?>"/><br />
	video Link: <input type="text" name="mlink" value="<?php echo $row['link']; ?>"/><br />
	picture Link: <input type="text" name="plink" value="<?php echo $row['picture_link']; ?>"/><br />
	Article: <textarea name="article" ><?php echo $row['article']; ?></textarea><br />
	<input type="submit" name="submit" />
	

	</form>
<?php } ?>

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
		$query = "select link,picture_link from videos where id = {$id}";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		$piclink = "../".$row['picture_link'];
		$vidlink= "../".$row['link'];
		unlink($piclink);
		unlink($vidlink);
		///////////////////////////////////
	} catch (Exception $e) {

	}
	$query = "delete from videos where id = {$id}";
	$result = get_result($query);
	echo 'deleted';
	header("LOCATION: edit_videos.php");
}

?>

<a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>

</div>
<?php
mysqli_close($connection);
include("footer.php");
}else {header("LOCATION: alogin.php");}
?>
