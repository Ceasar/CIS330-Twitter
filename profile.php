<?php
//Includes:
session_start();
include_once("./databaseTools.php");
//Page-specific
//-------------

//DEBUG
$_SESSION['id'] = 3; //Fake a session
$_SESSION['username'] = "userA";

//Query the db for the user
$user = db_getUserById($_GET['id']);
$id = $user['ID'];
$private = $user['private'];
$first = $user['first_name'];
$last = $user['last_name'];
$location = $user['location'];
$bio = $user['bio'];
$url = $user['URL'];
$followers = db_getFollowers($id);

function displayUserProfile() {
	global $first, $last, $location, $bio, $url;
	?>
	<h2><?php echo $first." ".$last; ?></h2>
	<span>Location: <?php echo $location;?></span>
	<p>Bio: <?php echo $bio;?></p>
	<p>URL: <a href="<?php echo $url;?>"/><?php echo $url;?></a></p>
	<?php
}

function displayNewsFeed() {
	global $id;
	$tweets = db_getUserTweets($id);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($tweets) ) {
		echo "<li>@". $row['usr'] ." tweeted ". $row['msg'] ."</li>";
	}
}

function displayFollowers() {
	global $followers;
	//Loop through the set of followers
	foreach ($followers as $follower) {
		$first_name = $follower['first_name'];
		$last_name = $follower['last_name'];
		$full_name = $first_name." ".$last_name;
		echo "<li>@". $full_name ."</li>";
	}
}

function displayFollowing() {
	global $id;
	//Query the db for users that the profiled user follows
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE follower=".$id." and users.id=followee";
	$result = run_sql($query);
	//Loop through the set of followers
	while ( $user=mysql_fetch_array($result) ) {
		$first_name = $user['first_name'];
		$last_name = $user['last_name'];
		$full_name = $first_name." ".$last_name;
		echo "<li>@". $full_name ."</li>";
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

<head>
	<!-- This makes the title display the username if the client is logged in -->
	<title>Twitter - News Feed
		<?php
			if ( isset($_GET['id']) ) {
				echo " - " . $_GET['id'];
			}
		?>
	</title>
	<link rel="stylesheet" href="styles.css" type="text/css"">
</head>

<body>
	<div id="header">
		<h1>Twitter Project</h1>
	</div>
	
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
					<?php displayNewsFeed(); ?>
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
</body>

</html>
