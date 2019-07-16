<?php ob_start();
require("../functions.php");
require("../session.php");
$connection = connect_DB();
if(cleared(4)) {
	include("header.php");
	if(isset($_POST['submit'])) {
		$fileFolder = NULL;
		/**************
		 * checking the files for errors
		 */
		if ($_FILES['file']['error'] == 0){
			/****************
			 * checking the file type of the submitted file
			 */
			$fileType = $_FILES['file']['type'];
			/*******************
			 * checking to see which file is being submited to determine
			 * the folder where it would be stored
			 */
			if($fileType == "image/jpeg" || $fileType == "image/jpg" || $fileType == "image/gif" || $fileType == "image/png") {
				$fileFolder = "images";
			}elseif ($fileType == "video/mp4" || $fileType == "video/x-msvideo" || $fileType == "video/3gpp") {
				$fileFolder = "videos";
			}elseif  ($fileType == "audio/mp3" || $fileType == "audio/mpeg") {
				$fileFolder = "audios";
			}else {
				$fileFolder = "others";
			}
			
			/*********************************
			 * attempting to upload the file to the desired folder
			 */
			$file_location = "../files/".$fileFolder."/".$_FILES['file']['name'];	
			if(move_uploaded_file($_FILES['file']['tmp_name'],$file_location)) {
				$type = $fileFolder;
				$link = mysqli_real_escape_string($connection,"files/".$fileFolder."/".$_FILES['file']['name']);
				$query = "insert into files (type,link) ";
				$query .= "values ('{$type}','{$link}')";					
				if($result = get_result($query)) {
					echo "file uploaded to ".$link;
				}
				
			}else {
				echo "file upload failed";
			}
				
		}else {
			echo "file contains error";
		}
	}
	/*************************************
	 * 
	 * attempting to delete the file fom the database as 
	 * well as from the file manager
	 */
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
			$query = "select link from files where id = {$id}";
			$result = get_result($query);
			$row = mysqli_fetch_assoc($result);
			$link = "../".$row['link'];
			unlink($link);
			///////////////////////////////////
		} catch (Exception $e) {

		}
		$query = "delete from files where id = {$id}";
		$result = get_result($query);
	}

	
	
?>
	<form action = "file_upload_manager.php" method="post" enctype="multipart/form-data" >
		File: <input type="file" name="file" required/><br />
		<input type="submit" name="submit" />
	<form>
<?php 
	$query = "select * from files";
	$result = get_result($query);
?>

	<table border="5px">
			<th>
				<td colspan="10" align="center"></td>

			</th>
			<tr>
				<td>file</td>
				<td>link</td>
				<td>ACTION</td>

			</tr>
		<?php 
			while($row = mysqli_fetch_assoc($result)) { 
				/*************************
				 * checking to see if the file type is images
				 ****************************/
			if($row['type'] == "images") {		
		?>
				<tr>
					<td><img style= "width: 70px; height: 70px;" src="../<?php echo $row['link'];?>" /></td>
					<td><?php echo $row['link'];?></td>
					<td><a href="file_upload_manager.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
					
				</tr>
			<?php } ?>
					<!----------------------------------
				checking to see if the file type is videos
				--------------------------------->
			<?php if($row['type'] == "videos") { ?>
				<tr>
					<td>
						<video style= "width: 70px; height: 70px;" controls>
							<source src="../<?php echo $row['link'];?>" />
							audio not supported by your browser
						</video>
					</td>
					<td><?php echo $row['link'];?></td>
					<td><a href="file_upload_manager.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
				</tr>
			<?php } ?>
				<!----------------------------------
				checking to see if the file type is audios
				--------------------------------->
			<?php if($row['type'] == "audios") { ?>
				<tr>
					<td>
						<audio style= "width: 70px;" controls>
							<source src="../<?php echo $row['link'];?>" />
							audio not supported by your browser
						</audio>
					</td>
					<td><?php echo $row['link'];?></td>
					<td><a href="file_upload_manager.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
				</tr>
			<?php } ?>
				<!----------------------------------
				checking to see if the file type is others
				--------------------------------->
			<?php if($row['type'] == "others") { ?>
				<tr>
					<td>
						
					</td>
					<td><?php echo $row['link'];?></td>
					<td><a href="file_upload_manager.php?id=<?php echo $row['id'];?>&action=delete">delete</a></td>
				</tr>
			<?php } ?>
		<?php } ?>
	</table>


<?php
include("footer.php");
mysqli_close($connection);
}else {echo "permission not granted";}
?>
