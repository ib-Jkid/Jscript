<?php ob_start();
require("../functions.php");
require("../session.php");
$connection = connect_DB();
if(cleared(4)) {
	include("header.php");
?>
<ul>
	<li><a href="file_ref.php?table=images">IMAGES</a></li>
	<li><a href="file_ref.php?table=audios">AUDIOS</a></li>
	<li><a href="file_ref.php?table=videos">VIDEOS</a></li>
	<li><a href="file_ref.php?table=others">OTHERS</a></li>
</ul>
<?php 
	$query = "select * from files";
	$result = get_result($query);
?>
<?php if($_GET['table'] == "images") { ?>
	<table border="5px">
		<th>
			<td colspan="10" align="center">IMAGES</td>
		</th>
		<tr>
			<td>file</td>
			<td>link</td>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)) { if($row['type'] == "images") { ?>	
			<tr>
				<td><img style= "width: 70px; height: 70px;" src="../<?php echo $row['link'];?>" /></td>
				<td><?php echo $row['link'];?></td>	
			</tr>
		<?php } }?>	

	</table>
<?php } ?>

<?php if($_GET['table'] == "videos") { ?>
	<table border="5px">
		<th>
			<td colspan="10" align="center">VIDEOS</td>
		</th>
		<tr>
			<td>file</td>
			<td>link</td>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)) { if($row['type'] == "videos") { ?>	
			<tr>
				<td>
					<video style= "width: 70px; height: 70px;" controls>
						<source src="../<?php echo $row['link'];?>" />
						audio not supported by your browser
					</video>
				</td>
				<td><?php echo $row['link'];?></td>	
			</tr>
		<?php } }?>	

	</table>
<?php } ?>

<?php if($_GET['table'] == "audios") { ?>
	<table border="5px">
		<th>
			<td colspan="10" align="center">VIDEOS</td>
		</th>
		<tr>
			<td>file</td>
			<td>link</td>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)) { if($row['type'] == "audios") { ?>	
			<tr>
				<td>
					<audio style= "width: 70px; height: 70px;" controls>
						<source src="../<?php echo $row['link'];?>" />
						audio not supported by your browser
					</audio>
				</td>
				<td><?php echo $row['link'];?></td>	
			</tr>
		<?php } }?>	

	</table>
<?php } ?>

<?php if($_GET['table'] == "others") { ?>
	<table border="5px">
		<th>
			<td colspan="10" align="center">VIDEOS</td>
		</th>
		<tr>
			<td>file</td>
			<td>link</td>
		</tr>
		<?php while($row = mysqli_fetch_assoc($result)) { if($row['type'] == "others") { ?>	
			<tr>
				<td>
					
				</td>
				<td><?php echo $row['link'];?></td>	
			</tr>
		<?php } }?>	

	</table>
<?php } ?>

<?php
include("footer.php");
mysqli_close($connection);
}else {echo "permission not granted";}
?>
