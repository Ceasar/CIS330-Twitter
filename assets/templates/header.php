<div id="header">

	<!-- TODO: Put a picture here and float the <h1> right -->
	<img src="./assets/images/logo.png" id="headLogo" alt="logo"/>
	<h1>CIS 330 Twitter Project</h1>
	
	<!-- TODO: Float nav elements next to each other in individual buttons -->
	<ul id="navContainer">
		<!-- If the user is logged in show him the site navigation. Otherwise just allow them to login or create an account -->
		<?php if (isset($_SESSION['username'])) { ?>
			<li><a href="./profile.php?id=<?php echo $_SESSION['userid']?>"/>Profile</a></li>
			<li><a href="./feed.php">News Feed</a></li>
			<li><a href="./usercp.php">User CP</a></li>
			<li><a href="./logout.php">Logout</a></li>
			<li><form name="form" action="search.php" method="get">
  				<input type="text" name="search_text" />
  				<input type="submit" name="search_submit" value="Search" />
			</form></li>
		<?php } else { ?>
			<li><a href="./login.php"> Login </a></li>
			<li><a href="./accountCreation.php"> Create Account </a></li>
		<?php } ?>
	</ul>
	
</div> <!-- End Nav Div -->