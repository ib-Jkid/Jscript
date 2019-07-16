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


	/********************************************
	 * increasing the download number
	 * 
	 */
	if ($_GET['action'] == "downloading") {
		$id = $_GET['id'];
		$query = "select downloads from musics where song_id = '{$id}'";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		$downloads = $row['downloads'] + 1;
		$query = "update musics set downloads = {$downloads} where song_id = '{$id}'";
		$result = get_result($query);
	}
	/***********************************
	 * the below code gets the post submited and update the comment table
	 * the post is gotten from a form on this page
	 * 
	 * *********************************
	 */
	if(isset($_POST['submit']) && $_POST['comment'] != NULL) {
		$song_id = $_POST['song_id'];
		$username = $_POST['username'];
		$comment = mysqli_real_escape_string($connection,nl2br($_POST['comment']));
		$query = "insert into comments (song_id, username, comment, visibility) ";
		$query .= "values ('{$song_id}', '{$username}', '{$comment}', 1)";
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
		$query = "select * from musics where song_id = '{$id}'";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);
		if($row == NULL) {
			include("404.php");
			die("");
		}
	
	}else {
		header("LOCATION: index.php");
	}

?>
<script src="script/comment.js"></script>

<?php /*<!-------------------------------------------------------
the following lines of code takes the result from the above 
query and output them to the browser


--------------------------------------------------------> */ ?>

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
	
	<audio controls>
		<source src="<?php echo $row['link'];?>" />
		audio not supported by your browser
	</audio>
	<p>
	<small><a onclick = "liked()"><?php echo $row['likes']." ";?>likes   &#128077</a></small>  
	<small><a onclick = "disLiked()"><?php echo $row['dislikes']." ";?>dislikes   &#128078</a></small> 
	
	<?php /*<!---
		this section below submits a get request
		to this page then opens a new tab for the download 
		using javascript
	----> */ ?>

	<b><small style="float: right;">
	<a href="song_details.php?id=<?php echo $id?>&action=downloading" 
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
		/**
		 * --------------------------------------------------------------------
			the form bellow takes the comment and submits it to song_detail.php


			---------------------------------------------------------------------
		 */
	?>
	
	<form id = "commentForm" onsubmit="return commentSubmit()" action ="song_details.php?id=<?php echo $id; ?>" method="post">
		<input type="hidden" name="username" value="<?php echo $username;?>"/>
		<input type="hidden" name="song_id" value="<?php echo $id;?>"/>
		<textarea name="comment" placeholder="Comment here" required></textarea><br />
		<input type="submit" name="submit" value="post" />			
	</form>

	
<?php
/********************************
 * the below code gets the comments related to the 
 * song_id and then displays it on the screen
 * 
 * 
 */
$query = "select * from comments where song_id = '{$id}' order by id desc";
$result = get_result($query);
$i = 0;
while($row = mysqli_fetch_assoc($result)) {
?>


	
	
	<div class = "comments" id = <?php echo $row['id']; ?> >
		<h6><?php echo $row['username'];?></h6>
		<p><?php echo $row['comment'];?>
		<?php if (cleared(4)) {
		/*---------------------------------------
		-using the click event to call a javascript
		-function that enables use of Ajax for 
		-browsers with javascript
		-
		------------------------------------*/	
			
		?>
		
			<button onclick = "deleteComment(<?php echo $row['id']; ?>)">
				DELETE
			</button>	
		<?php } ?>
		</p>
	</div>


<?php $i++; if($i==10)break; }?>

</div>
<?php
include("footer.php");
    mysqli_close($connection);
    

?>
