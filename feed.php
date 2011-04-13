<?php
/* News Feed
 * ==========
 */

//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");
session_start();

//DEBUG
//$_SESSION['userid'] = "userA"; //Fake a session

//Page-specific Functions
//-----------------------
function displayNewsFeed() {
	//Make sure the user is logged in
	if ( !isset($_SESSION['userid']) ) {
		echo "You must be logged in to view tweets!";
		return;
	}
	
	//Query the db for all tweets/PMs related to the current user
	$query = "SELECT users.id as usr, tweets.message as msg\n"
		   . "FROM users, tweeted, tweets\n"
		   . "WHERE users.id=tweeted.userid and tweeted.tid=tweets.id\n"
		   . "ORDER BY tweets.ID DESC";
	$result = run_sql($query);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($result) ) {
			echo "<li><a href='./profile.php?id=" . $row['usr'] . "'>@". $row['usr'] ."</a> tweeted ". $row['msg'] ."</li>";
	}
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
	
	<div id="newsFeed">
			<h2>News Feed:</h2>
			<ul id="newsList">
				
				<!-- This function populates the newsfeed list with elements from the db -->
				
				<?php displayNewsFeed(); ?>
			</ul>
		</div>
		
		<!--  This draws a widget for submitting tweets. Exposed by 'newTweetWidget.php' -->
		<?php addTweetWidget(); ?>
	</div>
	
</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>