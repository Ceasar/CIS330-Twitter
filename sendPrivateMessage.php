<?php



/* Send private message page
 *
 */
 
//Includes:
include_once("./databaseTools.php");

//DEBUG:
//$_SESSION['id'] = "userA";

function addMessageWidget() {
    if( isset($_GET['userid']) ) {
        $messageDefault = "Write your message here. (Max 140 characters)";
        if (isset($_POST['submit'])) {
            $result = submitMessage();
            //If the user input was bad (e.g. too long), allow them to fix it 
            if (!$result) {
                createPostForm($_POST['message'], false);
                echo "Message was too long, try again. (max of 140 characters)<br/>";
            } else {
                //If it submitted correctly, display a new blank form
                createPostForm($messageDefault);
            }
        } else {
            //If we haven't submitted, display an new blank form
            createPostForm($messageDefault);
        }
    }

}

function createPostForm($text, $default=true) {
    ?>
	<form method="post" action="<?php $PHP_SELF;?>">
        Message To: <?php echo $_GET['userid']; ?><br/>
		<textarea rows="10" cols="30" name="message" onClick="clearText(event)" onKeyDown="changeText(event)"><?php echo $text ?></textarea><br/>
		<input type="submit" value="Send Message" name="submit">
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

function submitMessage() {
    $msg = $_POST['message'];
    $usr = $_SESSION['id'];
    $rec = $_GET['userid'];
    
    $result = db_addMessage($usr, $rec, $msg);
    if ($result) {
        echo "Message sent successfully.<br/>";
    }
    else {
        echo "Message was not sent.<br/>";
    }
    return $result;
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content -->
<div id="content">
    <h1>New Private Message</h1>
    <?php addMessageWidget(); ?>
</div>

<?php include_once("./assets/templates/footer.php");?>

</body>
</html>