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
?>


<section class="items" id = "items">
<h1>STORY LIST</h1>
<?php
/*************************************************
the below code gets info from the story table
and displays it in the browser 

**************************************************/
	$query = "select * from story where visibility = 1 order by id desc";
	$result = get_result($query);
	while ($row = mysqli_fetch_assoc($result)) {;
?>
	<a href="story_details.php?id=<?php echo $row['story_id'];?>">
	<div class = "home_list">
	<img src="<?php echo $row['picture_link']; ?>" />
	<p>
		
			<?php echo $row['title']; ?>
		
	</p>
<p class="date"><sub><i>posted: <?php echo date("d",$row['date'])." ".date("F",$row['date'])." ". date("Y",$row['date']) ?></i></sub></p>
</div></a>
<?php } ?>
</section>






<?php
	include("footer.php");
    mysqli_close($connection);
    

?>

