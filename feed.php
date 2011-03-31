<?php
/* News Feed
 * ==========
 */

//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");

//DEBUG
$_SESSION['username'] = "userA"; //Fake a session

//Page-specific Functions
//-----------------------
function displayNewsFeed() {
	//Query the db for all tweets/PMs related to the current user
	$query = "SELECT users.id as usr, tweets.message as msg\n"
		   . "FROM users, tweeted, tweets\n"
		   . "WHERE users.id=tweeted.userid and tweeted.tid=tweets.id";
	$result = run_sql($query);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($result) ) {
		echo "<li>@". $row['usr'] ." tweeted ". $row['msg'] ."</li>";
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