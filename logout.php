<?php
session_start();
/** 
 * logout.php: Logs a user out.
 * 
 */

function logout(){?>
	<div align=center>
	<div class="box" id="login">
		<p>
		<?php
		if (isset($_SESSION['id'])) {
			
			session_destroy();
			echo "You have sucessfully logged out.";
		}
		else {
			echo "How did you get here?";
		}
		?>
		</p>
		<p><a href="./index.php">Return to index</a></p>
	</div>
	</div>
<?php }
?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">

<?php logout(); ?>

</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>