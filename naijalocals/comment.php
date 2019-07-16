<?php ob_start();
/*******************************************
 * creating mysql connection 
 * calling the functions.php file
 * including the header file.
 ******************************************/
    require("functions.php");
    require("session.php");
    $connection = connect_DB();

    if(isset($_POST['username']) && $_POST['comment'] != NULL) {
		if(isset($_POST['song_id'])) {
			$id = $_POST['song_id'];
			$id_attr = 'song_id';
		}
		if(isset($_POST['story_id'])) {
			$id = $_POST['story_id'];
			$id_attr = 'story_id';
		}
		if(isset($_POST['video_id'])) {
			$id = $_POST['video_id'];
			$id_attr = 'video_id';
		}
		$username = $_POST['username'];
		$comment = mysqli_real_escape_string($connection,nl2br($_POST['comment']));
		$query = "insert into comments ({$id_attr}, username, comment, visibility) ";
		$query .= "values ('{$id}', '{$username}', '{$comment}', 1)";
		$result = get_result($query);
		if($result) {
			echo "1";
		}else {
			echo "";
		}
		




	}
?>
<?php
mysqli_close($connection);
    

?>