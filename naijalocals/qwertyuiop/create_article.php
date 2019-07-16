<?php ob_start();
require("../functions.php");
require("../session.php");

/*************************************************************
the following code takes data from a form through a post request
and creates a new row on the story table in the SQL DATABASE!!
******************************************************************
the for loop takes different text area and keeps them in different 
column in the DATABASE table


**************************************************************/
if (cleared(4)) {
	/**********************
	 * after so much  issue with loosing all that i have typed due to 
	 * failed form submission i have decided to save my write up 
	 * for future long content sake
	 * the following code works the shit out
	 */
	if(isset($_POST['title'])) {
		$title_value = $_POST['title'];
	}else {
		$title_value = "";
	}
	////////////////////////////////////////
	if(isset($_POST['author_name'])) {
		$author_name_value = $_POST['author_name'];
	}else {
		$author_name_value = "";
	}
	////////////////////////////////////////
	if(isset($_POST['type'])) {
		$type_value = $_POST['type'];
	}else {
		$type_value = "";
	}
	//////////////////////////////////////////
	if(isset($_POST['article'])) {
		$article_value = $_POST['article'];
	}else {
		$article_value = "";
	}

	///////////////////////////////////////////////
	require_once("header.php");
$connection = connect_DB();
if(isset($_POST['submit']) && $_POST['title'] != NULL) {
	if(isset($_FILES['image']['name'])) {
		if($_FILES['image']['error'] == 0) {
			
			$type = $_FILES['image']['type'];
			if($type == "image/jpg" || $type == "image/gif" || $type == "image/png" || $type == "image/jpeg") {
				$picture_location = "../images/article/".$_POST['title'].$_FILES['image']['name'];
				if(move_uploaded_file($_FILES['image']['tmp_name'],$picture_location)) {
					
					$title = mysqli_real_escape_string($connection,$_POST['title']);
					$type = mysqli_real_escape_string($connection,$_POST['type']);
					$author_name = mysqli_real_escape_string($connection,$_POST['author_name']);
					$visibility = $_POST['visibility'];
					/******
					 * inserting  nl-br function enables me  to connvert line bbreaks to br tag
					 */
					$article = mysqli_real_escape_string($connection,nl2br($_POST['article']));
					$link = mysqli_real_escape_string($connection,"images/article/".$_POST['title'].$_FILES['image']['name']);
					$story_id = mysqli_real_escape_string($connection,get_id($title));
					$query = "insert into story";
					$query .= " (title, author_name, likes, dislikes, date, type, visibility, article, picture_link, story_id) ";
					
					$time = time();
					$query .= "values ('{$title}','{$author_name}',0,0,'{$time}','{$type}', {$visibility}, '{$article}', '{$link}','{$story_id}')";
					if($result = get_result($query)) {echo "successfull";}else {echo "failed";}
				}else {
					echo "file upload failed";
				}
			}else {
				echo "invalid file type". $type;
			}
		} else {
			echo "an error has occured";
		}
	}else {
		echo "upload an image";
	}
}

?>
<!-----this----is-----a---------form---------->
<form action="create_article.php" method = "post" enctype="multipart/form-data" >
		<h1>CREATE ARTICLE</h1>
		Title: <input type="text" name="title" value="<?php echo $title_value?>"/><br />
		Type: <input type="text" name="type" value="<?php echo $type_value?>" /><br />
		Author Name: <input type="text" name="author_name" value="<?php echo $author_name_value?>"/><br />
		Image File: <input type="file" name="image" /><br />
		visibility: <select name="visibility">
				<option value="1">YES</option>
				<option value="0">NO</option>
			</select><br />
		Article: <textarea name="article" ><?php echo $article_value?></textarea><br />
<input type="submit" name="submit" value="upload"/>

</form>


<a href="../index.php">Go back</a>

<?php
mysqli_close($connection);
require_once("footer.php");
}else {header("LOCATION: alogin.php");}
?>
