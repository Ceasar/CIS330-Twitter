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
$user = db_getUserById($_GET['id']);
$id = $user['ID'];
$private = $user['private'];
$first = $user['first_name'];
$last = $user['last_name'];
$followers = db_getFollowers($id);

function displayUserProfile() {
	global $user;
	$first = $user['first_name'];
	$last = $user['last_name'];
	$location = $user['location'];
	$bio = $user['bio'];
	$url = $user['URL'];
	$email = $user['email'];
	$language = $user['lang'];
	$birthday = $user['birthday'];
	?>
	<h2><?php echo $first." ".$last; ?></h2>
	<span>Location: <?php echo $location;?></span>
	<p>Bio: <?php echo $bio;?></p>
	<p>URL: <a href="<?php echo $url;?>"/><?php echo $url;?></a></p>
	<p>Email: <?php echo $email;?></p>
	<p>Language: <?php echo $language;?></p>
	<p>Birthday: <?php echo $birthday;?></p>
	<?php
}

function displayUserTweets() {
	global $id, $first, $private;
	if ($private){
		$fids = db_getFollowerIds($id);
		$permitted = 0;
		foreach ($fids as $fid){
			if ($fid[0] == $_SESSION['id']){
				$permitted = 1;
			}
		}
		
		if ($permitted){
			$tweets = db_getUserTweets($id);
			echo "Total tweets: ".count($tweets);
			//Loop through the set of tweets
			foreach ($tweets as $tweet) {
				echo "<li>@". $first ." tweeted ". $tweet['msg'] ."</li>";
			}
		} else {
			echo "This user's information is private. Follow them to see their feed.";
		}
	} else {
		$tweets = db_getUserTweets($id);
		echo "Total tweets: ".count($tweets);
		//Loop through the set of tweets
		foreach ($tweets as $tweet) {
			echo "<li>@". $first ." tweeted ". $tweet['msg'] ."</li>";
		}
	}
}

function displayFavoriteTweets() {
	global $id, $first, $private;
	if ($private){
		$fids = db_getFollowerIds($id);
		$permitted = 0;
		foreach ($fids as $fid){
			if ($fid[0] == $_SESSION['id']){
				$permitted = 1;
			}
		}
		
		if ($permitted){
			printFavoriteTweets($id);
		} else {
			echo "This user's information is private. Follow them to see their feed.";
		}
	} else {
		printFavoriteTweets($id);
	}
}

function printFavoriteTweets($id){
	$tweets = db_getFavoriteTweets($id);
	echo "Total tweets: ".count($tweets);
	//Loop through the set of tweets
	foreach ($tweets as $tweet) {
		echo "<li>@". $tweet['usr']." tweeted ". $tweet['msg'] ."</li>";
	}
}

function displayFollowers() {
	global $followers;
	echo "Being followed by ".count($followers)." people.";
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
	$following = db_getFollowing($id);
	echo "Following ".count($following)." people.";
	//Loop through the set of following
	foreach ($following as $followed) {
		$first_name = $followed['first_name'];
		$last_name = $followed['last_name'];
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

function createPMForm() {
	?>
	<form method="get" action="./sendPrivateMessage.php?">
		<?php echo "<input type='hidden' name='userid' value='".$_GET['id']."'>"; ?>
		<input type="submit" value="Send PM">
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

function messageButton() {
	createPMForm();
}

?>

<html>
<?php include_once("./assets/templates/head.php");?>

<head>
	<!-- This makes the title display the username if the client is logged in -->
	<title>Twitter - Profile
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
		<div class="main-content">
			<div class="box" id="userProfile">
				<ul id="use">
					<!-- This function shows the user profile. -->
					<?php displayUserProfile(); ?>
				</ul>
			<?php followButton(); messageButton(); ?>
			</div>
			<div class="box"  id="userTweets">
				<h2>tweets:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<div class="scrollbox">
						<?php displayUserTweets(); ?>
					</div>
				</ul>
			</div>
			<div class="box"  id="favorites">
				<h2>favorites:</h2>
				<ul id="newsList">
					<!-- This function populates the newsfeed list with elements from the db -->
					<div class="scrollbox">
						<?php displayFavoriteTweets(); ?>
					</div>
				
				</ul>
			</div>
		

		
			<div class="box"  id="followers">
				<h2>followers:</h2>
				<ul id="newsList">
					<!-- This function populates the followers list. -->
					<div class="scrollbox"  id="follow">
					<?php displayFollowers(); ?>
					</div>
				</ul>

				<h2>following:</h2>
				<ul id="newsList">
					<!-- This function populates the following list. -->
					<div class="scrollbox"  id="follow">
					<?php displayFollowing(); ?>
					</div>
				</ul>
			</div>
		</div>
		 
	</div>

<?php include_once("./assets/templates/footer.php");?>

</body>

</html>
