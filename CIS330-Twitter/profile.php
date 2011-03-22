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
	   . "WHERE users.id='".$_SESSION['id']."'";
$result = run_sql($query);
$user = mysql_fetch_array($result);
$id = $user['ID'];
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$location = $user['location'];
$bio = $user['bio'];
$url = $user['URL'];

function displayUserProfile() {
	global $first_name, $last_name, $location, $bio, $url;
	?>
	<h2><?php echo $first_name." ".$last_name; ?></h2>
	<span>Location: <?php echo $location;?></span>
	<p>Bio: <?php echo $bio;?></p>
	<p>URL: <a href="<?php echo $url;?>"/><?php echo $url;?></a></p>
	<?php
}

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

function displayFollowers() {
	global $id;
	//Query the db for followers of the profiled user
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE followee=".$id." and users.id=follower";
	$result = run_sql($query);
	//Loop through the set of followers
	while ( $user=mysql_fetch_array($result) ) {
		$first_name = $user['first_name'];
		$last_name = $user['last_name'];
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
	//See if the user is even logged in
	if ( !isset($_SESSION['username']) ) {
		echo "You must be logged in to post tweets.<br/>";
	} else {
		if (isset($_POST['follow'])) {
			$user = $_SESSION['id'];
			$person = $_GET['id'];
			db_addFollower($user, $person)
			?>Following<?php
		} else {
			//If we haven't submitted, display an new blank form
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
			if ( isset($_SESSION['username']) ) {
				echo " - " . $_SESSION['username'];
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
					<!-- This function populates the newsfeed list with elements from the db -->
					<?php displayUserProfile(); ?>
				</ul>
			</div>
			
			<?php followButton();?>
		
			<div id="newsFeed">
				<h2>Timeline:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<?php //displayNewsFeed(); ?>
				</ul>
			</div>
		</div>
		
		<div id="dashboard">
			<div id="newsFeed">
				<h2>Followers:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<?php //displayFollowers(); ?>
				</ul>
			</div>
			
			<div id="newsFeed">
				<h2>Following:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<?php //displayFollowing(); ?>
				</ul>
			</div>
		</div>
		 
	</div>
</body>

</html>
