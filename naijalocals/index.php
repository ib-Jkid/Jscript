<?php ob_start(); //starting output buffering
	require("session.php");
	//importing the function file where most of my functions are located
	require("functions.php");
	//connecting to database by using a function created in the function file
	$connection = connect_DB();
	include("header.php");
?>

<?php 
	$query = "select * from slide";
	$result = get_result($query);

?>

<div class="slideshow-container">
	<?php while($row = mysqli_fetch_assoc($result)) {?>
		<div class="mySlides fade">
   			<img class= "home-img"src="<?php echo $row['link']?>" />
 		</div>
	<?php }?>
</div>

<div class="items">
<h1>LATEST GISTS</h1>
<?php
/*************************************************
the below code gets info from the story table
and displays it in the browser and limits the number 
of data to 5no 

**************************************************/
	$query = "select * from story where visibility = 1 order by id desc";
	$result = get_result($query);
	$i = 1;
	$viewNum = 4;
	while ($row = mysqli_fetch_assoc($result)) {$i++;
?>
	<a href="story_details.php?id=<?php echo $row['story_id'];?>">
	<div class = "home_list">
	<img src="<?php echo $row['picture_link']; ?>" />
	<p>
		
			<?php echo $row['title']; ?>
		
	</p>
<p class="date"><sub><i>posted: <?php echo date("d",$row['date'])." ".date("F",$row['date'])." ". date("Y",$row['date']) ?></i></sub></p>
</div></a>
<?php if($i >= $viewNum) {break;}} ?>
	</div>
	
<div class="items">
<h1>LATEST SONGS</h1>
<hr />
<?php
/*************************************************
the below code gets info from the musics table
and displays it in the browser and limits the number 
of data to 5no 

**************************************************/
	$query = "select * from musics where visibility = 1 order by id desc";
	$result = get_result($query);
	$i = 1;
	while ($row = mysqli_fetch_assoc($result)) {$i++;
?>
	<a href="song_details.php?id=<?php echo $row['song_id'];?>">
	<div class = "home_list">
	<img src="<?php echo $row['picture_link']; ?>" />
	<p>
		
			<?php echo $row['title']." by ".$row['artist_name']; ?>
		
	
	</p>
	</div></a>
<?php if($i >= $viewNum) {break;}} ?>
	</div>


<div class="items">
<h1>LATEST VIDEOS</h1>
<hr />
<?php
/*************************************************
the below code gets info from the videos table
and displays it in the browser and limits the number 
of data to 5no 

**************************************************/
	$query = "select * from videos where visibility = 1 order by id desc";
	$result = get_result($query);
	$i = 1;
	while ($row = mysqli_fetch_assoc($result)) {$i++;
?>
	<a href="video_details.php?id=<?php echo $row['video_id'];?>">
	<div class = "home_list">
	<img src="<?php echo $row['picture_link']; ?>" />
	<p>
		
			<?php echo $row['title']." by ".$row['artist_name']; ?>
		
	
	</p>
	</div></a>
<?php if($i >= $viewNum) {break;}} ?>
	</div>


<?php
	include("footer.php");
	mysqli_close($connection);
	
?>
<script src="script/script.js" type="text/javascript">
</script>
