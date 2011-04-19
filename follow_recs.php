<?php
session_start();
/* Mentions page
 * 
 */

//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");

//error reporting
ini_set('display_errors',1); 
error_reporting(E_ALL);
//DEBUG:
//$_SESSION['id'] = "userA"; //Fake a session

function displayFollowRecs() {
	//Query the db for all tweets
	$user = $_SESSION['id'];
	$l_name = $_SESSION['lastname'];
	$loc = $_SESSION['location'];
	
    $query = "SELECT users.id as usr, users.location as location, users.last_name as last_name"
                . " FROM users"
                . " WHERE users.id <>'$user' AND (users.last_name='$l_name' OR users.location='$loc')";
    $result = run_sql($query);
    
    //Loop through, pick out as necessary
    $counter = 0;
    while($row=mysql_fetch_array($result)){
    	$alreadyFollowed = false;
    	if($counter == 10){
    		break;
    	}
    	$followers = db_getFollowerIds($row['usr']);
    	foreach($followers as $follower){
    		if($follower[0] == $user){
    			$alreadyFollowed = true;
    		}
    	}
    	if(!$alreadyFollowed){
    		echo "<a href=\"./profile.php?id=" . $row['usr'] . "\">@" . $row['usr']. "</a>";
    		if($row['last_name'] == $l_name){
    			echo "- You both have the same last name!";
    		}
    		if($row['location'] == $loc){
    			echo "- You both live in $loc!";
    		}
    		echo "\n";
    	}
    	$counter++;
    }
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content -->
<div id="content">
	<div class="box" id="recs">
    <ul id="recsList">
    	<h2>Who You Should Follow!</h2>
        <?php displayFollowRecs(); ?>
    </ul>
    </div>
</div>

<?php include_once("./assets/templates/footer.php");?>

</body>
</html>