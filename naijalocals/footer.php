			
					
				
				</div>
					
					
				</div>
				<div class="aside">
					<h3>Also Read:</h3>
					<?php 
						$i = 0;
						$query = "select * from story where visibility = 1 order by id desc";
						$result = get_result($query);
						while ($row = mysqli_fetch_assoc($result)) {
							$i++;
						if ($i >= 10)
							break;
					?>
						<a href="story_details.php?id=<?php echo $row['story_id'];?>">
							<div>
								<img src = "<?php echo $row['picture_link']; ?>" />
								<p>
									<?php echo $row['title'];?>
								</p>
							</div>
						</a><br /><hr />
				
					<?php
						}
					?>
						
				</div>
				<div class="pages" id= "pages">
					<script src="script/pages.js"></script>

				</div>
				
				<div class="footer">
					<?php
						$query = "select * from about_us";
						$result = get_result($query);
						$row = mysqli_fetch_assoc($result);
					?>
					
						
							<div class="our_vision">
								<div class="text">
									<?php echo $row['vision']; ?>
								</div>
							</div>
						<div class="contact_us">
							<a target= "_blank" href="<?php echo $row['instagram']?>" >
								<img src="images/logo/instagram.png" class="social-logo" />
							</a>	
							<a target= "_blank" href="<?php echo $row['facebook']?>" >
								<img src="images/logo/facebook.png" class="social-logo" />
							</a>
							<a target= "_blank" href="<?php echo $row['email']?>" >
								<img src="images/logo/envelope.png" class="social-logo" />
							</a>
							<a target= "_blank" href="<?php echo $row['twitter']?>" >
								<img src="images/logo/twitter.png" class="social-logo" />
							</a>
						</div>
						
						<p align="center">© 2019 by 9JALOCALS. All Rights Reserved </p>
				</div>
				
				
			<div id = "ads" class= "ads" >
					<button style="color: white; margin-left: 94%;" onclick = "hideAds()" >close</button>
			</div>
		</div>
		<script src="script/mobile.js" type = "text/javascript"></script>
	</body>
</html>
