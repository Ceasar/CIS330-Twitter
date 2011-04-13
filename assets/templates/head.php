<head>
	<link rel="stylesheet" type="text/css" href="./styles.css">
	<!-- This makes the title display the username if the client is logged in -->
	<title>Twitter
		<?php
			if ( isset($_SESSION['userid']) ) {
				echo " - " . $_SESSION['userid'];
			}
		?>
	</title>
</head>