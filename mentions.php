<?php
session_start();
/* Mentions page
 * 
 */

//Includes:
include_once("./databaseTools.php");
include_once("./newTweetWidget.php");

//DEBUG:
//$_SESSION['id'] = "userA"; //Fake a session

function displayMentionedTweets() {
	//Query the db for all tweets
    $query = "SELECT users.id as usr, tweets.message as msg\n"
                . "FROM users, tweeted, tweets\n"
                . "WHERE users.id=tweeted.userid and tweeted.tid = tweets.id";
    $result = run_sql($query);
    //Loop through, pick out as necessary
    $mention = "@" . $_SESSION['id'];
    while( $row=mysql_fetch_array($result) ){
        
        $pos = strpos($row['msg'],$mention);
        if($pos === false) {
            // mention NOT found in message
            // do nothing, skip
            ;
        }
        else {
            // mention found in message
            echo "<li>@". $row['usr'] ." tweeted ". $row['msg']."</li>";
        }
        
    }
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content -->
<div id="content">
    <ul id="mentionList">
        <?php displayMentionedTweets(); ?>
    </ul>
    
    <?php addTweetWidget(); ?>
</div>

<?php include_once("./assets/templates/footer.php");?>

</body>
</html>