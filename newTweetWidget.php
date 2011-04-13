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
	if ( !isset($_SESSION['userid']) ) {
		echo "You must be logged in to post tweets.<br/>";
	} else {
		//The page self-submits so if it submitted, try to post the tweet
		$tweetDefault = "Write your tweet here. (Max 140 characters)";
		if (isset($_POST['submit'])) {
			$result = NT_submitTweet();
			//If the user input was bad (e.g. too long), allow them to fix it 
			if (!$result) {
				NT_createPostForm($_POST['message'], false);
				echo "Tweet was too long, try again. (max of 140 characters)<br/>";
			} else {
				//If it submitted correctly, display a new blank form
				NT_createPostForm($tweetDefault);
			}
		} else {
			//If we haven't submitted, display a new blank form
			NT_createPostForm($tweetDefault);
		}
	}
	
	//Close out the container element for this widget
	echo "</div>";
}

//This draws the form element for the widget. The argument determines the initial content.
//------
function NT_createPostForm($text, $default=true) {
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
function NT_submitTweet() {
	//Get the submitted values
	$msg = $_POST['message'];
	$usr = ($_SESSION['userid']);
	
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
	
	//Update any news feeds on the page
	?>
	<script type="text/javascript">
	
	</script>
	<?php
}

?>