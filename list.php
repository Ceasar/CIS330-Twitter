<?php
//Includes:
session_start();
include_once("./databaseTools.php");
//Page-specific
//-------------

//DEBUG
//$_SESSION['id'] = 3; //Fake a session
//$_SESSION['username'] = "userA";

//Query the db for the user
$list = db_getListById($_GET['id']);

function displayListTweets() {
	global $id, $first, $private;
	if ($private){
		$fids = db_getFollowerIds($id);
		if (in_array($_SESSION['id'], $fids)){
			$tweets = db_getUserTweets($id);
			//Loop through the set of tweets
			foreach ($tweets as $tweet) {
				echo "<li>@". $first ." tweeted ". $tweet['msg'] ."</li>";
			}
		} else {
			echo "hi";
			echo $_SESSION['id'];
			echo " ".$fids;
			echo "This user's information is private. Follow them to see their feed.";
		}
	} else {
		$tweets = db_getUserTweets($id);
		//Loop through the set of tweets
		foreach ($tweets as $tweet) {
			echo "<li>@". $first ." tweeted ". $tweet['msg'] ."</li>";
		}
	}
}

function createFollowForm() {
	?>
	<form method="post" action="<?php $PHP_SELF;?>">
		<input type="submit" value="Follow" name="follow">
	</form>
	<?php
}

function createUnfollowForm() {
	?>
	<form method="post" action="<?php $PHP_SELF;?>">
		<input type="submit" value="Unfollow" name="unfollow">
	</form>
	<?php
}

function followButton() {
	global $followers, $first, $last;
	//See if the user is even logged in
	if ( isset($_SESSION['username']) ) {
		//Check to see if we are already following the person.
		if (count($followers)) {
			if (isset($_POST['unfollow'])) {
				$user = $_SESSION['id'];
				$person = $_GET['id'];
				db_removeFollower($user, $person);
			} else{
				//Loop through the set of followers
				foreach ($followers as $follower) {
					if ($follower['ID'] == $_SESSION['id']){
							createUnfollowForm();
							return;
					}
				}
			}
		}
		
		//Update DB or show a follow button.
		if (isset($_POST['follow'])) {
			$user = $_SESSION['id'];
			$person = $_GET['id'];
			db_addFollower($user, $person);
			?>Following<?php
		} else {
			//If we aren't following then create a follow button.
			createFollowForm();
		}
	}
}

?>

<html>
<?php include_once("./assets/templates/head.php");?>

<head>
	<!-- This makes the title display the username if the client is logged in -->
	<title>Twitter - List
		<?php
			if ( isset($_GET['id']) ) {
				echo " - " . $_GET['id'];
			}
		?>
	</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body>

<?php include_once("./assets/templates/header.php");?>
	
	<div id="content">
		<div id="main-content">
			<div id="userProfile">
				<ul id="userProfile">
					<!-- This function shows the user profile. -->
					<?php displayUserProfile(); ?>
				</ul>
			</div>
			
			<?php followButton();?>
		
			<div id="newsFeed">
				<h2>Timeline:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements 
from the db -->
					<?php displayListTweets(); ?>
				</ul>
			</div>
		</div>
		
		<div id="dashboard">
			<div id="newsFeed">
				<h2>Followers:</h2>
				<ul id="newsList">
					<!-- This function populates the followers list. -->
					<?php displayFollowers(); ?>
				</ul>
			</div>
			
			<div id="newsFeed">
				<h2>Following:</h2>
				<ul id="newsList">
					<!-- This function populates the following list. -->
					<?php displayFollowing(); ?>
				</ul>
			</div>
		</div>
		 
	</div>

<?php include_once("./assets/templates/footer.php");?>

</body>

</html>
