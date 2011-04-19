<?php
session_start();
include_once("./databaseTools.php");

function execute_search(){
	// Get the search variable from URL
	$var = @$_GET['search_text'] ;
	$trimmed = trim($var); //trim whitespace from the stored variable

	// rows to return
	$limit=10;

	// check for an empty string or no search term.
	if (($trimmed == "") || (!isset($var))){
		exit;
	}

	$result = db_searchForUser($trimmed);
	
	echo "<h2>Search Results</h2>";
	while ($row=mysql_fetch_array($result)) {
		echo "<a href=\"./profile.php?id=" . $row['id'] . "\">"
				. $row['id'] . " - " . $row['first_name'] . " " . $row['last_name'] ."</a>";
	}
}
?>

<html>
<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
	<?php execute_search();?>
</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>

