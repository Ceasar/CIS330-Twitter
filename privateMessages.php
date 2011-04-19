<?php
session_start()
/* Private messages page
 *
 */

//Includes:
include_once("./databaseTools.php");

//DEBUG:
//$_SESSION['id'] = "userA";

function displayPrivateMessages() {
    //Query the DB for all private messages directed at this user
    $query = "SELECT users.id as usr, messages.message as msg\n"
                . "FROM users, messages, messaged\n"
                . "WHERE users.id=messaged.senderid and messaged.mid=messages.id and messaged.receiverid='".$_SESSION['id']."'";
    $result = run_sql($query);
    //Loop through messages
    while( $row=mysql_fetch_array($result) ){
        echo "<li>Message from @". $row['usr'] .": ". $row['msg'] ."</li>";
    }
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">

    <h1>Inbox:</h1>
    <ul id="pmList">
        <?php displayPrivateMessages(); ?>
    </ul>

</div> <!-- End Content Div -->


<?php include_once("./assets/templates/footer.php");?>

</body>
</html>