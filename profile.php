<?php
//Includes:
include_once("./databaseTools.php");
session_start(); //Get the session variabbles for the user (If any...)

//DEBUG
//$_SESSION['id'] = 0; //Fake a session
//$_SESSION['username'] = "userA";

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
	<p>Name:     <?php if ($first)    {echo $first." ".$last;} else {echo "N/A";}?></p>
	<p>Location: <?php if ($location) {echo $location;} else {echo "N/A";}?></p>
	<p>Bio:      <?php if ($bio)      {echo $bio;} else {echo "N/A";}?></p>
	<p>URL:      <?php if ($url)      {echo "<a href='".$url."'/>".$url."</a>";} else {echo "N/A";}?></p>
	<?php
}

function displayNewsFeed() {
	global $id;
	//Query the db for all tweets/PMs related to the current user
	$query = "SELECT users.id as usr, tweets.message as msg\n"
		   . "FROM users, tweeted, tweets\n"
		   . "WHERE users.id='".$id."' and users.id=tweeted.userid and tweeted.tid=tweets.id\n"
		   . "ORDER BY tweets.ID DESC";
	$result = run_sql($query);
	//Loop through the set of tweets
	while ( $row=mysql_fetch_array($result) ) {
			echo "<li><a href='./profile.php?id=" . $row['usr'] . "'>@". $row['usr'] ."</a> tweeted ". $row['msg'] ."</li>";
	}
}

function getFollowers() {
	global $id;
	//Query the db for followers of the profiled user
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE followee='".$id."' and users.id=follower";
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
		echo "<li><a href='./profile.php?id=".$follower['ID']."'>@".$full_name."</a></li>";
	}
}

function displayFollowing() {
	global $id;
	//Query the db for users that the profiled user follows
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE follower='".$id."' and users.id=followee";
	$result = run_sql($query);
	//Loop through the set of followers
	while ( $user=mysql_fetch_array($result) ) {
		$first_name = $user['first_name'];
		$last_name = $user['last_name'];
		$full_name = $first_name." ".$last_name;
		echo "<li><a href='./profile.php?id=".$user['ID']."'>@".$full_name."</a></li>";
	}
}

function createPostForm() {
	?>
	<form method="post" action="<?php $PHP_SELF;?>">
		<input type="submit" value="Follow User" name="follow">
	</form>
	<?php
}

function followButton() {
	global $followers, $id;

	//See if the user is even logged in
	if ( !isset($_SESSION['userid']) ) {
		echo "You must be logged in to follow users!<br/>";
	} else {
		$user = $_SESSION['userid'];
		$person = $id;
		
		//Make sure we arent looking at our own profile
		if ($user==$person) {
			return;
		}
		
		//Check to see if we are already following the person.
		if (count($followers) != 0){
			if (in_array($user, $followers[0])){
			?>Following<?php
			return;
			}
		}
		
		//Update DB or show a follow button.
		if (isset($_POST['follow'])) {
			db_addFollower($user, $person)
			?>You are currently following this user<?php
		} else {
			//If we aren't following then create a follow button.
			createPostForm();
		}
	}
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
	<div id="leftCol">
		<div id="userProfile">
			<h2>User Profile:</h2>
			<!-- This function shows the user profile. -->
			<?php displayUserProfile(); ?>
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
		
	<div id="rightCol">
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
	 
</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>
