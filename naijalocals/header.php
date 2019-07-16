<?php  
	//performing query to the database to get values from the navigations table
	$query = "select name,link from navigations where visibility = 1";
	$result = get_result($query);
	/*******************
	 * Attempting to set the input value of the search 
	 * 
	 */
	if(isset($_GET['search'])) {
		$search = $_GET['search'];
	}else {
		$search = '';
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
<!--linking to the style sheet-->
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="script/ad.js" type = "text/javascript"></script>


</head>
<body>
	<div class="background">
		<div class="header">
			<img class="main-logo" src="images/logo/naijalocals-logo-white.png" />
			<form class="search-form" action="search_result.php" method="get">
					<input type="text" name="search" placeholder="search" value='<?php echo $search;?>' required/>
					<input type= "submit" value="&#128269;"/>
			</form>
		</div>
			<div class="nav" id="navigation">
			<img id="menuImg" src="images/logo/mobile-menu.png"	onclick= "displayMenu()"/>
			<ul>
				<?php
				//echoing the result from the query to the webpage 
					while ($row = mysqli_fetch_assoc($result)) {
					echo '<li><a href="'.$row['link'].'">'.$row['name'].'</a></li>';
					
					}
				//freeing up the result
				mysqli_free_result($result);
				?>

			</ul></div>
		<div class="main-section">
			
			<div class="log">
				
				<?php if (cleared(1)) { ?>
						<p style="font-size: 10px; text-align: right;">admin</p>
						<form style="font-size: 10px; text-align: right;" action="logout.php" method="post" >
							<input type="submit" name="logout" value="log out"/>
						</form>
				<?php }else { if($_SESSION['logged_in']) {?>
						<p>HI <?php echo $_SESSION['username']; ?></p>
						<?php }else {?>
							<p><a href="login.php">LOGIN</a>&#9;<a href="sign_up.php"> SIGN UP</a></p>
						<?php } ?>	
					
				<?php } ?>
			</div>
			
			<div class="content">

