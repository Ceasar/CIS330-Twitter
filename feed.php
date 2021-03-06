<?php
session_start();
/* News Feed
 * ==========
 */

//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");

//DEBUG
//$_SESSION['username'] = "userA"; //Fake a session
//error reporting
ini_set('display_errors',1); 
error_reporting(E_ALL);

//Page-specific Functions
//-----------------------
function displayNewsFeed() {
	//Query the db for all tweets/PMs related to the current user
	$query = "SELECT users.id as usr, tweets.message as msg, tweets.id as id\n"
	. "FROM users, tweeted, tweets\n"
	. "WHERE users.id=tweeted.userid and tweeted.tid=tweets.id\n"
	. "ORDER BY tweets.datetime DESC";
	$result = run_sql($query);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($result) ) {
		//print tweet with star if favorite
		if(is_favorite($row['id'])){
			echo "<div class=\"tweet\"><li><img src=\"./assets/images/star.jpeg\">"
			."<a href=\"./profile.php?id=" . $row['usr'] . "\">@" . $row['usr']. "</a> tweeted ". $row['msg'] ."</li>"; //print tweet
		}
		else{
			echo "<div class=\"tweet\"><li><a href=\"./profile.php?id=" . $row['usr'] . "\">@" . $row['usr']. "</a> tweeted ". $row['msg'] ."</li>";
		}
		displayTweetOptions($row['id']);	//print options for tweet
		echo "</div>";
	}
}

//Displays a user's feed.
function displayUserFeed($id) {
	$following = db_getFollowing($id);
	//Loop through the set of following
	foreach ($following as $followed) {
		echo $followed[0];
		$name = $followed[0]['first_name'];
		$tweets = db_getUserTweets($followed[0]['id']);
		echo $tweets[0];
		foreach ($tweets as $tweet) {
			echo $tweet;
			echo "<li>@". $name ." tweeted ". $tweet[0]['msg'] ."</li>";
		}
	}
}

/*
 * creates buttons for various tweeting options
 */
function displayTweetOptions($tid){
	$uid = $_SESSION['id'];
	if(is_favorite($tid)){
		echo "<form name=\"rem_favorite\" method=\"post\" action=\"tweetActions.php\">"
		."<input type=hidden name=\"uid\" value=\"$uid\">"
		."<input type=hidden name=\"tid\" value=\"$tid\">"
		."<input type=submit name=\"remove_fav_button\" value=\"Remove Fav\">"
		."<input type=submit name=\"retweet_button\" value=\"ReTweet\"></form>";
	}
	else{
		echo "<form name=\"favorite\" method=\"post\" action=\"tweetActions.php\">"
		."<input type=hidden name=\"uid\" value=\"$uid\">"
		."<input type=hidden name=\"tid\" value=\"$tid\">"
		."<input type=submit name=\"fav_button\" value=\"Fav\">"
		."<input type=submit name=\"retweet_button\" value=\"ReTweet\"></form>";
	}
}

function is_favorite($tid){
	$uid = $_SESSION['id'];
	$query = "SELECT favorites.uid "
	. "FROM favorites "
	. "WHERE favorites.uid = '$uid' AND favorites.tid = '$tid'";

	$results = run_sql($query);
	if(mysql_num_rows($results)!=0){
		return true;
	}
	return false;
}
?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

	<!-- Unique page content goes here. -->
	<div id="content">
		<div class="main-content">
			<div class="box" id="newsFeed">
				<h2>News Feed:</h2>
				<a href="./feed.php">Tweets</a> <a
					href="./mentions.php?id=<?php echo $_SESSION['id']?>">Mentions</a>
				<a href="./privateMessages.php">Private Messages</a>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<div class="scrollbox" id="newsbox">
					<?php displayNewsFeed(); ?>
					</div>
				</ul>
			</div>

			<div class="box" id="createTweet">
				<!--  This draws a widget for submitting tweets. Exposed by 'newTweetWidget.php' -->
				
				<?php addTweetWidget(); ?>
				
			</div>
		</div>
	</div>
	</div>
	<!-- End Content Div -->


	<?php include_once("./assets/templates/footer.php");?>

</body>
</html>