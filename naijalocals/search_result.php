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
	$response = false;
	if(!isset($_GET['search']))
		{$_GET['search']= NULL;}
?>
<div class="items" id = "items">
	<?php 
		/***********************************
		 * showing the result for the story table
		 */
		if(isset($_GET['search'])) {
			$word = mysqli_real_escape_string($connection,$_GET['search']);
		/***********************************
		 * showing the result for the musics table
		 */
		/****************************** 

		*********************************
		 this bellow code na scam
		 
		 **********************************
		 
		 /*************************** */
			$query = "select * from story where title like '%{$word}%'";
			$result = get_result($query);
			
				while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
					$response = true;
	?>
					<div class = "home_list">
						<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="story_details.php?id=<?php echo $row['story_id'];?>">
								<?php echo $row['title']." by ".$row['author_name']; ?>
							</a>
					
						</p>
					</div>
	<?php 
				}
			$query = "select * from musics where title like '%{$word}%'";
			$result = get_result($query);

			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="song_details.php?id=<?php echo $row['song_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			$query = "select * from videos where title like '%{$word}%'";
			$result = get_result($query);

			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="video_details.php?id=<?php echo $row['video_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			$query = "select * from story where author_name like '%{$word}%'";
			$result = get_result($query);

				while ($row = mysqli_fetch_assoc($result)) {
					//result  is available
					$response = true;
	?>
					<div class = "home_list">
						<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="story_details.php?id=<?php echo $row['story_id'];?>">
								<?php echo $row['title']." by ".$row['author_name']; ?>
							</a>
					
						</p>
					</div>
	<?php 
				}
			$query = "select * from musics where artist_name like '%{$word}%'";
			$result = get_result($query);

			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="song_details.php?id=<?php echo $row['song_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			$query = "select * from videos where artist_name like '%{$word}%'";
			$result = get_result($query);

			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="video_details.php?id=<?php echo $row['video_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			/**********************
			 * 
			 * 
			 * 
			 */
			$query = "select * from story where article like '%{$word}%'";
			$result = get_result($query);
				while ($row = mysqli_fetch_assoc($result)) {
					//result  is available
					$response = true;
	?>
					<div class = "home_list">
						<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="story_details.php?id=<?php echo $row['story_id'];?>">
								<?php echo $row['title']." by ".$row['author_name']; ?>
							</a>
					
						</p>
					</div>
	<?php 
				}
			$query = "select * from musics where article like '%{$word}%'";
			$result = get_result($query);
			

			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="song_details.php?id=<?php echo $row['song_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			$query = "select * from videos where article like '%{$word}%'";
			$result = get_result($query);
			
			while ($row = mysqli_fetch_assoc($result)) {
				//result  is available
				$response = true;
	?>
				<div class = "home_list">
					<img src="<?php echo $row['picture_link']; ?>" />
						<p>
							<a href="video_details.php?id=<?php echo $row['video_id'];?>">
								<?php echo $row['title']." by ".$row['artist_name']; ?>
							</a>
								
						</p>
								</div>
	<?php 
			}
			if(!$response) {
				echo "<p>No result  found!!</p>";
			}
		}
	?>


</div>
<?php
    include("footer.php");
	mysqli_close($connection);
?>