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
	$database="lamp_newlamp";
	
	$connection = mysql_connect("localhost",$dbUsername,$dbPassword);
	mysql_select_db($database) or die( "Unable to select database");
	if (!($result = mysql_query($query, $connection))) {
	  echo ("<b>SQL Error:</b> ".mysql_error() ."<br>Query: " . $query);
		exit(1);
	}
	mysql_close();
	return $result;
}



/*
function run_sql($query) {
	$dbUsername="cpdpn_dailypenn";
  $dbPassword="l;asdb8a";
  $database="dpn_writ35";
	
	$connection = mysql_connect('localhost',$dbUsername,$dbPassword);
	mysql_select_db($database) or die( "Unable to select database");
	if (!($result = mysql_query($query, $connection))) {
	  echo ("<b>SQL Error:</b> ".mysql_error() ."<br>Query: " . $query);
		exit(1);
	}
	mysql_close();
	return $result;
}
*/

?>
