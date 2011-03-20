<!--This is the index page.-->
<?php
include_once("databaseTools.php");
include_once("tools.php");
session_start();
/** 
 * dailypennsylvanian.com GA Story List Package
 *
 * index.php: Lists claimed and unclaimed stories. Also shows pending claims to admins.
 * @version  2.0 (2/26/2011)
 * @author   Ceasar Bautista (ceasarb@seas.upenn.edu)
 * 
 */
?>
<LINK REL="stylesheet" TYPE="text/css" HREF="styles.css">
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" /> 

<body>
	<a href=index.php><img id="flag" src="assets/flag.png" alt="The Daily Pennsylvanian" /></a>
	<table border = 1>
		<tr>
			<td width = "71.5%"></td>
			<td width = "4.5%" align=center><?php
			if (isset($_SESSION['permissions']) && $_SESSION['permissions'] = "admin") { ?>
				<form name="admin" method="post" action="admin/edit.php">
					<input type=submit name="create" value="Add a Story">
				</form><?php
			}?>
			</td>
			<td width = "25%" align=center><?php
			if (isset($_SESSION['userid'])){?>
				Welcome back! | <a href="authentication/logout.php">Log out?</a><?php
			}
			else{?>
				<form name="dpappslogin" method="post" action="authentication/login.php">
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
				</form><?php
			}?>
			</td>
		</tr>
	</table><?php
	display_unclaimed_assignments();
	if (isset($_SESSION['permissions']) && $_SESSION['permissions'] = "admin") {
		approve(); display_pending_assignments();}
	display_claimed_assignments();
	?>
</body>