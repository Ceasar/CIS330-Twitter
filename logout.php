<?php
if(!isset($_SESSION)) {session_start();}
/** 
 * logout.php: Logs a user out.
 * 
 */
?>
<title>Penn Twitter</title>
<link rel="stylesheet" type="text/css" href="./styles.css">

<body>
	<br> 
	<div align=center>
		<p>
		<?php
		if (isset($_SESSION['userid'])) {
			session_destroy();
			echo "You have sucessfully logged out.";
		}
		else {
			echo "How did you get here?";
		}
		?>
		</p>
		<br>
		<p><a href="./index.php">Return to index</a></p>
	</div>
</body>