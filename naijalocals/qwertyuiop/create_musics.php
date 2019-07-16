<?php ob_start();
require("../functions.php");
require("../session.php");
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
	if(isset($_POST['artist'])) {
		$artist_name_value = $_POST['artist'];
	}else {
		$artist_name_value = "";
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
	//////////////////////////////////////////
	if(isset($_POST['language'])) {
		$language_value = $_POST['language'];
	}else {
		$language_value = "";
	}
	///////////////////////////////////////
$connection = connect_DB();
include("header.php");
/*************************************************************
the code bellow creates a new row in the musics table taking info 
from the form on this page



**************************************************************/
if(isset($_POST['submit']) && $_POST['title']== !NULL) {
/***********************************************
 * the bellow code checks to see if an error occured in the file upload
 * 
 * 
 */
	if ($_FILES['mfile']['error'] == 0){
		if ($_FILES['pfile']['error'] == 0) {
/***********************************************************
 * 
 * the codes bellow checks to see if the file format is accepted or not
 */
			$imageFileType = $_FILES['pfile']['type'];
			$audioFileType = $_FILES['mfile']['type'];
			if ($imageFileType == "image/jpeg" || $imageFileType == "image/gif" || $imageFileType == "image/png") {
				if($audioFileType == "audio/mp3" || $audioFileType == "audio/mpeg") {
					$picture_location = "../images/music/".$_POST['artist'].$_FILES['pfile']['name'];
					$music_location = "../audios/".$_POST['artist'].$_FILES['mfile']['name'];
/********************************************************************************
 * 
 * 
 * the following codes upload the file is all the checks are ok
 */
					if(move_uploaded_file($_FILES['mfile']['tmp_name'],$music_location)){
						if(move_uploaded_file($_FILES['pfile']['tmp_name'],$picture_location)){
							$title = mysqli_real_escape_string($connection,$_POST['title']);
							$artist = mysqli_real_escape_string($connection,$_POST['artist']);
							$language = mysqli_real_escape_string($connection,$_POST['language']);
							$year = $_POST['year'];
							$visibility = $_POST['visibility'];
							$type = mysqli_real_escape_string($connection,$_POST['type']);
							$song_id = mysqli_real_escape_string($connection,get_id($title));
							/******************************************
							the location of the file in the database is written to suit the files
							that would likely call this files*
							***********************************************/
							$mlink = mysqli_real_escape_string($connection,"audios/".$_POST['artist'].$_FILES['mfile']['name']);
							$plink = mysqli_real_escape_string($connection,"images/music/".$_POST['artist'].$_FILES['pfile']['name']);
/***************************************************************************************88
 * 
 * 
 * uploading the file into the database
 */							/***
							 line to br tag is used to edit text
 							*/
							$article = mysqli_real_escape_string($connection,nl2br($_POST['article']));
							$query = "insert into musics (title,artist_name,language,production_year,type,likes,dislikes,downloads,visibility,article,link,picture_link,song_id)";
							$query .= " values ('{$title}','{$artist}','{$language}',{$year},'{$type}',0,0,0,{$visibility},'{$article}','{$mlink}','{$plink}','{$song_id}')";
							$result = get_result($query);
							mysqli_free_result($result);
							echo "successfull";
/***********************************************************************************************
 * 
 * 
 * 
 * informations to return when an error occurs
 */
						}else {
							echo "failed to upload picture file";
						}
					}else {
						echo "failed to upload music file";
					}
				}else {
					echo "invalid audio format".$_FILES['mfile']['type'];
				}
			}else {
				echo "invalid image format";
			}
		}else {
			echo "picture file contains errors";
		}
	}else {
		echo "audio file contains errors";
	}
	
}

?>
<!------------------------------------------------------------------------------
this form bellow uploades the content


------------------------------------------------------------------------------->
<div class="musics_form">
<h1>New song</h1>
<form action = "create_musics.php" method="post" enctype="multipart/form-data" >
	Title: <input type="text" name="title" value="<?php echo $title_value?>" /><br />
	Artist Name: <input type="text" name="artist" value="<?php echo $artist_name_value ?>" /><br />
	Language: <input type="text" name="language" value="<?php echo $language_value?>" /><br />
	Production-Year: <input type="number" name="year" min="2000" step="1" max="2099" 		value="2016"/><br />
	visibility: <select name="visibility">
		<option value="1">YES</option>
		<option value="0">NO</option></select><br />
	Type: <input type="text" name="type" value="<?php echo $type_value?>" /><br />
	Music: <input type="file" name="mfile" /><br />
	picture: <input type="file" name="pfile" /><br />
	Article: <textarea name="article" ><?php echo $article_value ?></textarea><br />
	<input type="submit" name="submit" />
<form><br />
<a href="../index.php">Go back</a>
<link href="ad.css" type="text/css" rel="stylesheet"/>
</div>
<?php
mysqli_close($connection);
include("footer.php");
}else {header("LOCATION: alogin.php");}
?>
