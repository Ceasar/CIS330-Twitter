<?php
/* New Tweet Widget
 * ================
 * Description: 
 *  Include this script on your page then call 'addTweetWidget()' wherever you want this in your page.
 */

//Includes:
include_once("./databaseTools.php");



//This function draws the whole widget
//------
function addTweetWidget() {
	//Put the div/header for this widget on the page
	?>
	<div class='newTweet'>
	<h2>Create Tweet:</h2>
	<?php
	
	//See if the user is even logged in
	if ( !isset($_SESSION['username']) ) {
		echo "You must be logged in to post tweets.<br/>";
	} else {
		//The page self-submits so if it submitted, try to post the tweet
		$tweetDefault = "Write your tweet here. (Max 140 characters)";
		if (isset($_POST['submit'])) {
			$result = submitTweet();
			//If the user input was bad (e.g. too long), allow them to fix it 
			if (!$result) {
				createPostForm($_POST['message'], false);
				echo "Tweet was too long, try again. (max of 140 characters)<br/>";
			} else {
				//If it submitted correctly, display an new blank form
				createPostForm($tweetDefault);
			}
		} else {
			//If we haven't submitted, display an new blank form
			createPostForm($tweetDefault);
		}
	}
	
	//Close out the container element for this widget
	echo "</div>";
}

//This draws the form element for the widget. The argument determines the initial content.
//------
function createPostForm($text, $default=true) {
	?>
	<form method="post" action="<?php $PHP_SELF;?>">
		<textarea rows="10" cols="30" name="message" onClick="clearText(event)" onKeyDown="changeText(event)"><?php echo $text ?></textarea><br/>
		Private? <input type="checkbox" value="1" name="privacy"/>
		<input type="submit" value="Post" name="submit">
		Remaining:<input readonly type="text" id="lenCount" size=3 maxlength=3 value=<?php echo 140-(strlen($text)+1) ?>>
	</form>
	<script type="text/javascript">
		function clearText(e) {
			if (e.target.value=='<?php echo ($default?$text:"") ?>') {
				e.target.value = "";
				document.getElementById("lenCount").value = 0;
			}
		}
		function changeText(e) {
			document.getElementById("lenCount").value = 140-(e.target.value.length+1);
		}
	</script>
	<?php
}

// Attempts to submit the result of the form submission. Returns: Bool whether or not the input was valid
//------
function submitTweet() {
	//Get the submitted values
	$msg = $_POST['message'];
	$usr = ($_SESSION['id']);
	
	//Determine privacy setting from checkbox
	$priv = false;
	if(isset($_POST['privacy']) && $_POST['privacy'] == '1') {
		$priv = true;
	}
	
	//Try to insert the message into the db and return whether the insertion was successful
	$result = db_addTweet($usr, $msg, $priv);
	if ($result) {
		echo "@".$usr." ".($priv?"privately":"")." tweeted '".$msg."'<br/>";
	}
	return $result;
}

?>