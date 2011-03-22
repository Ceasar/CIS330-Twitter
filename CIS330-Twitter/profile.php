<?php
//Includes:
include_once("./databaseTools.php");

//DEBUG
$_SESSION['id'] = 0; //Fake a session
$_SESSION['username'] = "userA";

//Page-specific
//-------------

//Query the db for the user
$query = "SELECT * "
	   . "FROM users "
	   . "WHERE users.id='".$_GET['id']."'";
$result = run_sql($query);
$user = mysql_fetch_array($result);
$id = $user['ID'];
$first = $user['first_name'];
$last = $user['last_name'];
$location = $user['location'];
$bio = $user['bio'];
$url = $user['URL'];
$followers = getFollowers();

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
	//Query the db for all tweets/PMs related to the current user
	$query = "SELECT users.id as usr, tweets.message as msg\n"
		   . "FROM users, tweeted, tweets\n"
		   . "WHERE users.id=". $id ." and users.id=tweeted.userid and tweeted.tid=tweets.id";
	$result = run_sql($query);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($result) ) {
		echo "<li>@". $row['usr'] ." tweeted ". $row['msg'] ."</li>";
	}
}

function getFollowers() {
	global $id;
	//Query the db for followers of the profiled user
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE followee=".$id." and users.id=follower";
	$result = run_sql($query);
	//Loop through the set of followers
	$followers = array();
	while ( $follower=mysql_fetch_array($result) ) {
		$followers[] = $follower;
	}
	return $followers;
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

function createPostForm() {
	?>
	<form method="post" action="<?php $PHP_SELF;?>">
		<input type="submit" value="Follow" name="follow">
	</form>
	<?php
}

function followButton() {
	global $followers;
	//See if the user is even logged in
	if ( !isset($_SESSION['username']) ) {
		echo "You must be logged in to post tweets.<br/>";
	} else {
		//Check to see if we are already following the person.
		if (count($followers) != 0){
			if (in_array($_SESSION['id'], $followers[0])){
			?>Following<?php
			return;
			}
		}
		
		//Update DB or show a follow button.
		if (isset($_POST['follow'])) {
			$user = $_SESSION['id'];
			$person = $_GET['id'];
			db_addFollower($user, $person)
			?>Following<?php
		} else {
			//If we aren't following then create a follow button.
			createPostForm();
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
					<!-- This function populates the newsfeed list with elements from the db -->
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
