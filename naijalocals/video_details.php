<?php ob_start();
/*******************************************
 * creating mysql connection 
 * calling the functions.php file
 * including the header file.
 ******************************************/
    require("functions.php");
    require("session.php");
    $connection = connect_DB();
	include("header.php");
	if(!isset($_GET['action'])) {
		$_GET['action'] = NULL;
	}

	/***********************************
	 * the below code gets the post submited and update the comment table
	 * the post is gotten from a form on this page
	 * 
	 * *********************************
	 */
	if(isset($_POST['submit']) && $_POST['comment'] != NULL) {
		$video_id = $_POST['video_id'];
		$username = $_POST['username'];
		$comment = mysqli_real_escape_string($connection,nl2br($_POST['comment']));
		$query = "insert into comments (video_id, username, comment, visibility) ";
		$query .= "values ('{$video_id}', '{$username}', '{$comment}', 1)";
		$result = get_result($query);
		




	}
	
	/********************************************
	 * increasing the download number
	 * 
	 */
	if ($_GET['action'] == "downloading") {
		$id = $_GET['id'];
		$query = "select downloads from videos where video_id = '{$id}'";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		$downloads = $row['downloads'] + 1;
		$query = "update videos set downloads = {$downloads} where video_id = '{$id}'";
		$result = get_result($query);
	}
	/**********************************************
	 * the below code gets the id of the selected 
	 * song from the get request sent through the 
	 * url the uses the id to get details about the song 
	 * from the database.
	 * 
	 */
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$query = "select * from videos where video_id = '{$id}'";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		if($row == NULL) {
			header("LOCATION: index.php");
		}
	
	}else {
		header("LOCATION: index.php");
	}
	

?>
<script src="script/comment.js"></script>
<!-------------------------------------------------------
the following lines of code takes the result from the above 
query and output them to the browser


-------------------------------------------------------->
<div class="main-items">
	<div class="main_detail">
		<img src="<?php echo $row['picture_link'] ?>" class="music_img" />
		<ul>
			<li>TITLE: <?php echo $row['title']?></li>
			<li>ARTIST: <?php echo $row['artist_name']?></li>
			<li>RELEASED: <?php echo $row['production_year']?></li>
			<li>LANGUAGE: <?php echo $row['language']?></li>
			<li>GENRE: <?php echo $row['type']?></li>

		</ul>
	</div>
	
	<div class="text">
			<?php echo $row['article']; ?>
			<p>please ENJOY!!!</p>
	</div>
	
	<video controls>
		<source src="<?php echo $row['link'];?>" />
		audio not supported by your browser
	</video>
	<p>
	<small><a href="#"><?php echo $row['likes']." ";?>likes   &#128077</a></small>  
	<small><a href="#"><?php echo $row['dislikes']." ";?>dislikes   &#128078</a></small> 
	<!---
		this section below submits a get request
		to this page then opens a new tab for the download 
		using javascript
	---->
	<b><small style="float: right;">
	<a href="video_details.php?id=<?php echo $id?>&action=downloading" 
		onclick="window.open('<?php $x = $row['link'];echo $x; ?>');"
	>
		
			<?php echo $row['downloads']." ";?>downloads
	</a>
	</small></b>
	</p>

</div>
<hr />
<div class="items" id="commentItems">
	<h1>POST A COMMENT</h1>
	<?php 
		if ($_SESSION['logged_in']) {
			$username = $_SESSION['username'];

			
		}
		else {
			echo "<p><a href='login.php'>LOGIN</a> to post a comment
			
			<br /> post anonymously<p>";
			$username = 'Anonymous';
		}

	?>
	<!--------------------------------------------------------------------
		the form bellow takes the comment and submits it to song_detail.php


	--------------------------------------------------------------------->
	<form id = "commentForm" onsubmit="return commentSubmit()" action ="video_details.php?id=<?php echo $id; ?>" method="post">
		<input type="hidden" name="username" value="<?php echo $username;?>"/>
		<input type="hidden" name="video_id" value="<?php echo $id;?>"/>
		<textarea rows='10' cols='30' name="comment" placeholder="Comment here" required></textarea><br />
		<input type="submit" name="submit" value="post" />			
	</form>


<?php
/********************************
 * the below code gets the comments related to the 
 * song_id and then displays it on the screen
 * 
 * 
 */
$query = "select * from comments where video_id = '{$id}' order by id desc";
$result = get_result($query);
?>
<?php 
while($row = mysqli_fetch_assoc($result)) {
?>
	<div class= "comments" >
		<h6><?php echo $row['username'];?></h6>
		<p><?php echo $row['comment'];?>
		<?php if (cleared(4)) {?>
			<button onclick = "deleteComment(<?php echo $row['id']; ?>)">
				DELETE
			</button>	
		<?php } ?>
		</p>
	</div>


<?php }?>
</div>

<?php
 include("footer.php");
    mysqli_close($connection);
   

?>

