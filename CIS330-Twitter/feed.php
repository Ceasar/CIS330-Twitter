<?php
//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");

//DEBUG
$_SESSION['username'] = "userA"; //Fake a session

//Page-specific
//-------------

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

<head>
	<!-- This makes the title display the username if the client is logged in -->
	<title>Twitter - News Feed
		<?php
			if ( isset($_SESSION['username']) ) {
				echo " - " . $_SESSION['username'];
			}
		?>
	</title>
</head>

<body>
	<div id="header">
		<h1>Twitter Project</h1>
	</div>
	
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
</body>

</html>
