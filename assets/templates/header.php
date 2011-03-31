<div id="header">

	<!-- TODO: Put a picture here and float the <h1> right -->
	<img id="headLogo" src="#"/>
	<h1>CIS 330 Twitter Project</h1>
	
	<!-- TODO: Float nav elements next to each other in individual buttons -->
	<ul id="navContainer">
		<!-- If the user is logged in show him the site navigation. Otherwise just allow them to login or create an account -->
		<?php if ( isset($_SESSION['username']) ) { ?>
			<li><a href="./profile.php"/>Home</a></li>
			<li><a href="./feed.php">News Feed</a></li>
			<li><a href="./usercp.php">User CP</a></li>
			<li><a href="./logout.php">Logout</a></li>
		<?php } else { ?>
			<li><a href="./login.php"> Login </a></li>
			<li><a href="./accountCreation.php"> Create Account </a></li>
		<?php } ?>
	</ul>
	
</div> <!-- End Nav Div -->