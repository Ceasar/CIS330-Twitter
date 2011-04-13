<?php
/* Base Template
 * ================
 * Description: 
 *  This is how all pages should look when you first start them. 
  * Put your page's unique content in the "content" div.
 */

//Includes:
include_once("./databaseTools.php");
session_start(); //Get the session variabbles for the user (If any...)
?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
	
	<p> Page content goes here! </p>
	
</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>