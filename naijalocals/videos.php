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
    <h1>VIDEO LIST</h1>
    <?php
/*************************************************
the below code gets info from the videos table
and displays it in the browser 

**************************************************/
        $query = "select * from videos where visibility = 1 order by id desc";
        $result = get_result($query);
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <a href="video_details.php?id=<?php echo $row['video_id'];?>">
	<div class = "home_list">
        <img src="<?php echo $row['picture_link']; ?>" />
        <p>
            
                <?php echo $row['title']." by ".$row['artist_name']; ?>
           
        </p>
	</div> </a>
        <?php } ?>
</section>






<?php
    include("footer.php");
    mysqli_close($connection);
    

?>

