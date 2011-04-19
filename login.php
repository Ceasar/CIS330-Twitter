<?php
session_start();
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

//Authenticates email and password by simply querying
//user database. Sets session variables upon success.
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
			$_SESSION['username'] = $result_firstname . " " . $result_lastname;
			$_SESSION['active'] = true;
			echo $_SESSION['firstname'];
			return true;
		}
	}
	return false;
}

//Displays options after a successful login
//TODO: I'm not sure if this is the best way to do this(?)
function login_success(){
	echo "Welcome " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</br>";
	echo "<a href=\"./profile.php\">Go to Profile</a></br>";
	echo "<a href=\"./profile.php\">Go to Control Panel</a></br>";
	echo "<a href=\"./logout.php\">Log out</a></br>";
}

//Displays options after a login failure
//TODO: I'm not sure if this is the best way to do this(?)
function login_failure(){
	echo "Login Failed.";
	echo "<p align=\"center\">Need an Account?<br>
			<a href=\"./accountCreation.php\">Register Here!</a></p>";
}

function display_login(){
	//if user is already logged in
	if (isset($_SESSION['userid'])) {
		echo "You are already logged in.";
	}
	//if user is NOT logged in, display form
	else {?>
	<!-- LOGIN FORM -->
				<form name="twitterlogin" method="post" action="<?php $PHP_SELF;?>">
					<table class="apps_table" align=right>
						<tr>
							<td>Username: </td>
							<td><input type="text" name="email"></td>
						</tr>
						<tr>
							<td>Password: </td>
							<td><input type="password" name="password"></td>
							<td colspan=2 align="center"><input type=submit name="submit_button" value="Login"></td>
						</tr>
					</table>
				</form>
		
	<?php }
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">

<?php display_login(); 
//checks if submit button has been pressed
if(isset($_POST['submit_button'])){
	//checks login information
	global $login_result;
	$login_result = auth_check_login($_POST['email'], $_POST['password']);
	//if login successful, redirect to profile
	if($login_result){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=feed.php">';
	}
	else{
		echo "login unsuccessful";
	}
}?>

</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>