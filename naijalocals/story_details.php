<?php 
/*******************************************
 * creating mysql connection 
 * calling the functions.php file
 * including the header file.
 ******************************************/
	require("functions.php");
	require("session.php");
	$connection = connect_DB();
	include("header.php");


?>
<?php
/***********************************
	 * the below code gets the post submited and update the comment table
	 * the post is gotten from a form on this page
	 * 
	 * *********************************
	 */
	if(isset($_POST['submit']) && $_POST['comment'] != NULL) {
		$story_id = $_POST['story_id'];
		$username = $_POST['username'];
		$comment = mysqli_real_escape_string($connection,nl2br($_POST['comment']));
		$query = "insert into comments (story_id, username, comment, visibility) ";
		$query .= "values ('{$story_id}', '{$username}', '{$comment}', 1)";
		$result = get_result($query);
		




	}
?>
<script src="script/comment.js"></script>
<?php 
	/*************************************************
	 * checking to see if the get request is set
	 * 
	 */
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$query = "select * from story where story_id = '{$id}'";
		$result = get_result($query);
		$row = mysqli_fetch_assoc($result);

		if($row == NULL) {
			header("LOCATION: index.php");
		}
	}else {
		header("LOCATION: index.php");
	}
?>
<!----------------------------------------------------
Displaying the result to the browser
-------------------------------------------------->
<div class = "main-items">
	<h1 class="story_header"><?php echo $row['title']?></h1>
	<div class="text">
		<?php echo $row['article']?>
	</div>
	<?php if($row['author_name'] != NULL) { ?>
		<p style = "text-align: right;">Written by <b><?php echo $row['author_name']?><b></p>
	<?php } ?>
</div>
<!--------------------------------------------
creating the comment form
------------------------------------------------>

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
		the form bellow takes the comment and submits it to story_detail.php


	--------------------------------------------------------------------->
	<form id = "commentForm" onsubmit="return commentSubmit()" action ="story_details.php?id=<?php echo $id; ?>" method="post">
		<input type="hidden" name="username" value="<?php echo $username;?>"/>
		<input type="hidden" name="story_id" value="<?php echo $id;?>"/>
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
$query = "select * from comments where story_id = '{$id}' order by id desc";
$result = get_result($query);
$i = 0;
while($row = mysqli_fetch_assoc($result)) {
?>
	<div class= "comments" >
		<h6><?php echo $row['username'];?></h6>
		<p><?php echo $row['comment'];?>
		<?php if (cleared(4)) {?>
			<button onclick = "deleteComment(<?php echo $row['id']; ?>)">
				DELETE
			</button>
		<?php } ?></p>
	</div>


<?php $i++; if($i==10)break; }?>
</div>
<?php
	include("footer.php");
    mysqli_close($connection);
    

?>