<!--This is the index page.-->
<?php
/* Index page
 * ================
 * Description: 
 * Contains initial login form and link to Account Creation
 */
 
//Includes:
include_once("./databaseTools.php");
session_start();
?>

<LINK REL="stylesheet" TYPE="text/css" HREF="styles.css">

<html>
<body>
	<h1 align = center>Penn Twitter</h1>
	<table align=center width=500 border = 3>
		<tr>
			<td align=center>
		<?php
		//if user is already logged in
			if (isset($_SESSION['userid'])){
		?>
				Welcome back! | <a href="./logout.php">Log out?</a>
		<?php
			}
		//if user is NOT already logged in
			else{
		?>
				<!-- LOGIN FORM -->
				<form name="twitterlogin" method="post" action="./login.php">
					<table class="apps_table" align=right>
						<tr>
							<td>Username: </td>
							<td><input type="text" name="email"></td>
						</tr>
						<tr>
							<td>Password: </td>
							<td><input type="password" name="password"></td>
							<td colspan=2 align="center"><input type=submit value="Login"></td>
						</tr>
					</table>
				</form>
		<?php
			}
		?>
			</td>
		</tr>
		<tr>
			<!-- ACCOUNT REGISTRATION LINK. -->
			<td align="center"><a href="./accountCreation.php">New User Registration</a></td>
		</tr>
	</table>
	<p>NOTE: For testing purposes, input username: test@test.com , password: test</p>
</body>
</html>