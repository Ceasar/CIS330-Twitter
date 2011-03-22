<?php
/* Login.php
 * ================
 * Description: 
 * Contains authentication and login functionality 
 */

//error reporting
ini_set('display_errors',1); 
error_reporting(E_ALL);

//INCLUDES
include_once("./databaseTools.php");

if(!isset($_SESSION)) {session_start();}

//Authenticates email and password by simply querying
//user database. Sets session variables upon success.
//TODO: implement some form of simple encryption
function auth_check_login($email, $password) {
	//database query
	$query = "SELECT * FROM users WHERE email = '".addslashes($email)."'";
	$result = run_sql($query);
	$db_field = mysql_fetch_assoc($result);

	//if query returns a result
	if(mysql_num_rows($result)){
		$result_password = mysql_result($result, 0, "password");
		$result_user = mysql_result($result, 0, "email");
		$result_firstname = mysql_result($result, 0, "first_name");
		$result_lastname = mysql_result($result, 0, "last_name");
		$userid = mysql_result($result, 0, "ID");
	
		//if email and corresponding password are valid
		if(($email == $result_user) && ($password == $result_password)){
			//sets session variables
			$_SESSION['userid'] = $userid;
			$_SESSION['email'] = $email;
			$_SESSION['firstname'] = $result_firstname;
			$_SESSION['lastname'] = $result_lastname;
			$_SESSION['active'] = true;
			return true;
		}
	}
	return false;
}

//Displays options after a successful login
//TODO: I'm not sure if this is the best way to do this(?)
function login_success(){
	echo "Welcome " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</br>";
	echo "<a href=\"/profile.php\">Go to Profile</a></br>";
	echo "<a href=\"/profile.php\">Go to Control Panel</a></br>";
	echo "<a href=\"/logout.php\">Log out</a></br>";
}

//Displays options after a login failure
//TODO: I'm not sure if this is the best way to do this(?)
function login_failure(){
	echo "Login Failed.";
	echo "<p align=\"center\">Need an Account?<br>
			<a href=\"/accountCreation.php\">Register Here!</a></p>";
}
?>

<html>
	<title>Penn Twitter</title>
	<link rel="stylesheet" type="text/css" href="../styles.css">
	<link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon" /> 

<body> 
	<p align=center>
	<?php
	//if user is already logged in
	if (isset($_SESSION['userid'])) {
		echo "You are already logged in.";
		login_success();
	}
	//if user is NOT logged in, verify form inputs
	else {
		if (isset($_POST['email'])) {
			//success
			if (auth_check_login($_POST['email'], $_POST['password'])) {
				login_success();
			}
			//failure
			else{
				login_failure();
			}
		}
	}
	?>
	</p>
	<br>
		<p align=center>
			<a href="../index.php">Return to index</a>
		</p>
</body>
</html>