<?php
//Contains the run_sql function.

/**
 * @ignore
 * @package  Tools
 */

 //Runs an SQL query.
function run_sql($query) {
	$dbUsername="root";
	$dbPassword="";
	$database="default";
	
	$connection = mysql_connect("localhost",$dbUsername,$dbPassword);
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

<<<<<<< HEAD
/* Facilitates follower requests to the db.
 * Args: $user - the username (id)
 *       $person - the message text
 * Returns: Boolean whether the tweet was successfully added.
 */
function db_addFollower($user, $person) {
	//Build the queries for the database
	
	//This creates a new tweet (The two queries need to run on the same connection for LAS_INSERT_ID() to work)
	$queries = array();
	$queries[] = "INSERT INTO follows(follower, followee)"
			.    "VALUES(". $user .",'". $person ."')";
	$results = run_statements($queries);
	
	//Make sure the insert succeeded
	if (!$results[0]) {
		return false;
	}
	
	//If we get here, everything worked
	return true;
}

=======
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


>>>>>>> dd4bd2f48ea745b8eb6a5e7caee803133f598b86
?>
