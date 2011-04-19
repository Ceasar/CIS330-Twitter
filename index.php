<?php
/* index
 * ==========
 */

//Includes:
session_start();
include_once("./login.php");
include_once("./databaseTools.php");

//Page-specific Functions
//-----------------------

?>

<html>
<div id = "wrapper">
<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">

</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</div>
</html>