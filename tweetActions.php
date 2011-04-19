<?php 
//start_session();
include_once './databaseTools.php';

//error reporting
ini_set('display_errors',1); 
error_reporting(E_ALL);

$tid = $_POST['tid'];
$usr = $_POST['uid'];

if(isset($_POST['fav_button'])){
	execute_favorite($usr, $tid);
}

if(isset($_POST['retweet_button'])){
	execute_retweet($usr, $tid);
}

if(isset($_POST['remove_fav_button'])){
	remove_favorite($usr, $tid);
}

function execute_favorite($uid, $tweet_id){
	/*$query = "SELECT users.id as usr, tweets.message as msg, tweets.id as id\n"
	 . "FROM users, tweeted, tweets\n"
	 . "WHERE users.id=tweeted.userid and tweeted.tid='$tweet_id' and tweets.id='$tweet_id'";
	 $result = run_sql($query);

	 if (!$result){
		return false;
		}
		//Loop through the set of tweets (will only be one in this case)
		while ($row=mysql_fetch_array($result) ) {
		echo "<li>@". $row['usr'] ." tweeted ". $row['msg'] ."</li>"; //print tweet*/
	
	$query2 = "INSERT INTO favorites "
	. "VALUES ('$uid', '$tweet_id')";
	$result2 = run_sql($query2);
	if (!$result2){
		echo "failed";
		return false;
	}
	
	/*}*/
	return true;
}

function remove_favorite($uid, $tweet_id){
	$query2 = "DELETE FROM favorites "
	. "WHERE favorites.uid = '$uid' AND favorites.tid = '$tweet_id'";
	$result2 = run_sql($query2);
	if (!$result2){
		echo "failed";
		return false;
	}
	return true;
}

function execute_retweet($uid, $tweet_id){
	$query = "SELECT users.id as usr, tweets.message as msg, tweets.id as id\n"
	. "FROM users, tweeted, tweets\n"
	. "WHERE users.id=tweeted.userid and tweeted.tid='$tweet_id' and tweets.id='$tweet_id'";
	$result = run_sql($query);

	if (!$result){
		return false;
	}
	//Loop through the set of tweets (will only be one in this case)
	while ($row=mysql_fetch_array($result) ) {
		echo "<li>@". $row['usr'] ." tweeted ". $row['msg'] ."</li>"; //print tweet
		$query2 = "INSERT INTO favorites "
             . "VALUES ('$uid', '$tweet_id')";
		$result2 = run_sql($query2);
		if (!$result2){
			echo "failed";
			return false;
		}
	}
	return true;
}

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=feed.php">';

?>