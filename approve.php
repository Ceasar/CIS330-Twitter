<?php
session_start();
/* News Feed
 * ==========
 */

//Includes:
include_once("./databaseTools.php");

//DEBUG
//$_SESSION['username'] = "userA"; //Fake a session


//Page-specific Functions
//-----------------------

function displaySucessfulApprove() {
	if ( isset($_SESSION['username']) ) {
		$uid = $_SESSION['id'];;
		if (isset($_POST['approve'])) {
			$id = $_POST['rid'];
			db_approve($id, $uid);
		}
	}
}

//Displays a list of unapproved followers.
function displayUnapproved() {
	if ( isset($_SESSION['username']) ) {
		$id = $_SESSION['id'];
		echo $id;
		$unapproved = db_getUnapproved($id);
		if ((count($unapproved)) != 0){
			//Loop through the set of following
			foreach ($unapproved as $rid) {
				$rid = $rid['id'];
				$request = db_getUserById($rid);
				$first_name = $request['first_name'];
				$last_name = $request['last_name'];
				$full_name = $first_name." ".$last_name;
				echo "<li>@". $full_name ."</li>";?>
				<form method="post" action="<?php $PHP_SELF;?>">
					<input type="hidden" value="<?php echo $rid;?>" name="rid">
					<input type="submit" value="Approve" name="approve">
				</form>
				<?php
			}
		} else {
			echo "You have no unnapproved followers.";
		}
	} else {
		echo "Log in to see if you have any unapproved followers.";
	}
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
	
	<div id="success">
		<?php displaySucessfulApprove(); ?>
		<?php displayUnapproved(); ?>
	</div>
	
</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>