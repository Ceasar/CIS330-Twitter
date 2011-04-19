<?php
//Contains the run_sql function.

/**
 * @ignore
 * @package  Tools
 */
 
 //Takes a list of tuples and turns them into a php array.
 function to_array($result){
	$array = array();
	while ( $object=mysql_fetch_array($result) ) {
		$array[] = $object;
	}
	return $array;
}

 //Runs an SQL query.
function run_sql($query) {
	$dbUsername = "root";
	$dbPassword = "root";
	$database = "default";
	
	$connection = mysql_connect("localhost", $dbUsername, $dbPassword);
	mysql_select_db($database) or die( "Unable to select database");
	if (!($result = mysql_query($query, $connection))) {
	  echo ("<b>SQL Error:</b> ".mysql_error() ."<br>Query: " . $query);
		exit(1);
	}
	mysql_close();
	return $result;
}

//Runs multiple sql queries on the same connection and returns an array of their results
function run_statements($queries) {
	//Auth Vars.
	$dbUsername="root";
	$dbPassword="";
	$database="default";
	
	//Connect to the db
	$connection = mysql_connect("localhost",$dbUsername,$dbPassword);
	mysql_select_db($database) or die( "Unable to select database");
	
	//Run all of the queries on the same connection and collate the results
	$results = array();
	foreach ($queries as $query) {
		$result =  mysql_query($query, $connection);
		if (!$result) {
		  echo ("<b>SQL Error:</b> ".mysql_error() ."<br>Query: " . $query);
			exit(1);
		}
		//Append the results
		$results[] = $result;
	}
	
	mysql_close();
	return $results;
}


//****************
// Helper Queries
//****************
/* Place queries here that retrieve/write useful stuff to the db
 * such as adding tweets, getting all tweets for a particular 
 * user, etc.
 */

/* Executes a search. Searches by user's ID or lastname.
 * Args: $searchtext - desired search (last name)
 * Returns: array of users matching query
 */
function db_searchForUser($searchtext){
	$query = "SELECT id, first_name, last_name "
				."FROM users "
				."WHERE last_name LIKE '%" . $searchtext . "%'"
				."or ID LIKE '%" . $searchtext . "%'";
	$results = run_sql($query);
	return $results;
	
}

/* Actually facilitates submitting tweets to the db.
 * Args: $user - the username (id)
 *       $message - the message text
 *       $private - whether the message should be private
 * Returns: Boolean whether the tweet was successfully added.
 */
function db_addTweet($user, $message, $private=false) {
	//Validate input (Just length for now...)
	if ( strlen($_POST['message'])>140 ) {
		return false;
	} 
	
	//Build the queries for the database
	
	//This creates a new tweet (The two queries need to run on the same connection for LAS_INSERT_ID() to work)
	$queries = array();
	$queries[] = "INSERT INTO tweets(private, message)"
			.    "VALUES(". ($private?"TRUE":"FALSE") .",'". addslashes($_POST['message']) ."')";
	$queries[] = "INSERT INTO tweeted(tID, userID)"
			.    "VALUES(LAST_INSERT_ID(),'". addslashes($user) ."')";
	$results = run_statements($queries);
	
	//Make sure the insert succeeded
	if (!$results[0]||!$results[1]) {
		return false;
	}
	
	//If we get here, everything worked
	return true;
}

/* Actually facilitates submitting messages to the db.
 * Args: $user - the username (id)
 *	 $receiver - message recipient (id)
 *       $message - the message text
 * Returns: Boolean whether the message was successfully added.
 */
function db_addMessage($user, $receiver, $message) {
	//Validate input (Just length for now...)
	if ( strlen($message)>140 ) {
		return false;
	} 
	
	//Build the queries for the database
	
	//This creates a new tweet (The two queries need to run on the same connection for LAS_INSERT_ID() to work)
	$queries = array();
	$queries[] = "INSERT INTO messages(message)"
			.    "VALUES('". addslashes($message) ."')";
	$queries[] = "INSERT INTO messaged(MID, senderID, receiverID)"
			.    "VALUES(LAST_INSERT_ID(),'". addslashes($user) ."','". addslashes($receiver) ."')";
	$results = run_statements($queries);
	
	//Make sure the insert succeeded
	if (!$results[0]||!$results[1]) {
		return false;
	}
	
	//If we get here, everything worked
	return true;
}

//Gets a user by his id
function db_getUserById($id) {
	$query = "SELECT * "
	   . "FROM users "
	   . "WHERE users.id='".$id."'";
	$result = run_sql($query);
	return mysql_fetch_array($result);
}

//Query the db for all tweets/PMs related to the current user
function db_getUserTweets($id) {
	$query = "SELECT users.id as usr, tweets.message as msg\n"
		   . "FROM users, tweeted, tweets\n"
		   . "WHERE users.id='$id' and users.id=tweeted.userid and tweeted.tid=tweets.id\n"
		   . "ORDER BY tweets.datetime DESC";
	$result = run_sql($query);
	$tweets = to_array($result);
	return $tweets;
}

/* Facilitates follower requests to the db.
 * Args: $id - the user id
 * Returns: A list of followers.
 */
function db_getFollowers($id) {
	//Query the db for followers of the profiled user
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE followee='$id' and users.id=follower";
	$result = run_sql($query);
	$followers = to_array($result);
	return $followers;
}

/* Facilitates follower requests to the db.
 * Args: $id - the user id
 * Returns: A list of ids.
 */
function db_getFollowerIds($id) {
	//Query the db for followers of the profiled user
	$query = "SELECT users.id "
		   . "FROM users, follows "
		   . "WHERE followee=".$id." and users.id=follower";
	$result = run_sql($query);
	$followers = to_array($result);
	return $followers;
}

/* Facilitates follower requests to the db.
 * Args: $id - the user id
 * Returns: A list of people that the user is following.
 */
function db_getFollowing($id) {
	//Query the db for followers of the profiled user
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE follower='$id' and users.id=followee";
	$result = run_sql($query);
	$following = to_array($result);
	return $following;
}

/* Facilitates follower requests to the db.
 * Args: $user - the username (id)
 *       $person - the message text
 * Returns: Boolean whether the tweet was successfully added.
 */
function db_addFollower($user, $person) {
	//Build the queries for the database
	
	$approved = 1;
	$private = $person['private'];
	if ($private){
		$approved = 0;
	}
	
	//This creates a new tweet (The two queries need to run on the same connection for LAS_INSERT_ID() to work)
	$queries = array();
	$queries[] = "INSERT INTO follows(follower, approved, followee)"
			.    "VALUES('$user','$approved','$person')";
	$results = run_statements($queries);
	
	//Make sure the insert succeeded
	if (!$results[0]) {
		return false;
	}
	
	//If we get here, everything worked
	return true;
}

function db_getUnapprovedFollowers($id){
	$query = "SELECT * "
		   . "FROM users, follows "
		   . "WHERE followee='$id' and users.id=follower and approved='0'";
	$result = run_sql($query);
	$unapproved = to_array($result);
	return $unapproved;
}

/* Facilitates follower requests to the db.
 * Args: $user - the username (id)
 *       $person - the message text
 * Returns: Boolean whether the follower was successfully removed.
 */
function db_removeFollower($user, $person) {
	//Build the queries for the database
	
	//This creates a new tweet (The two queries need to run on the same connection for LAS_INSERT_ID() to work)
	$queries = array();
	$queries[] = "DELETE FROM follows "
			.    "WHERE follower='". $user ."' and followee='". $person ."'";
	$results = run_statements($queries);
	
	//Make sure the insert succeeded
	if (!$results[0]) {
		return false;
	}
	
	//If we get here, everything worked
	return true;
}

/* Adds the user to the database
 * Args: $user - username (id)
 *       $first - first name
 *       $last - last name
 *       $email - e-mail address
 *       $private - privacy setting
 *       $lang - language
 *       $bio - bio
 *       $location - location
 *       $url - website
 *       $birthday - date (YYYY-MM-DD)
 * Returns: Boolean whether user was successfully added
 */
function db_addUser($user, $first, $last, $email, $private, $lang, $bio, $location, $url, $birthday) {
    $query = "INSERT INTO Users " . 
             "VALUES ($user, $first, $last, $email, $private, $lang, $bio, $location, $url, $birthday)";
    $result = run_sql($query);
    
    if (!$result){
        return false;
    }
    
    return true;
}

/* Update a user's information in the database
 * Args: $id - username (id)
 *       $first - first name
 *       $last - last name
 *       $email - e-mail address
 *       $private - privacy setting
 *       $lang - language
 *       $bio - bio
 *       $location - location
 *       $url - website
 *       $birthday - date (YYYY-MM-DD)
 * Returns: Boolean whether user was successfully added
 */
function db_updateUser($id, $first, $last, $email, $private, $lang, $bio, $location, $url, $birthday) {
    $query = "UPDATE users " . 
             "SET first_name='".$first."', last_name='".$last."', email='".$email."', private='".$private."',".
			 "lang='".$lang."', bio='".$bio."', location='".$location."', url='".$url."', birthday='".$birthday."'" .
			 "WHERE users.id='$id'";
    $result = run_sql($query);
    
    if (!$result){
        return false;
    }
    
    return true;
}
?>
