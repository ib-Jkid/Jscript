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


<div class="items" id = "items">
    <h1>MUSIC_LIST</h1>
    <?php
/*************************************************
the below code gets info from the musics table
and displays it in the browser 

**************************************************/
        $query = "select * from musics where visibility = 1 order by id desc";
        $result = get_result($query);
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <a href="song_details.php?id=<?php echo $row['song_id'];?>">
	<div class = "home_list" >
        <img src="<?php echo $row['picture_link']; ?>" />
        <p>
            
                <?php echo $row['title']." by ".$row['artist_name']; ?>
            
        </p>
	</div></a>
        <?php } ?>
        
    
   
</div>






<?php
    include("footer.php");
    mysqli_close($connection);
    

?>
