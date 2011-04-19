<?php

//Includes:
include_once("./databaseTools.php");

function displaySuccess() {
    $result = addUser();
    if (!$result) {
        echo "Account creation failed.";
        ?>
        <br /> <br />
        <a href="./accountCreation.php">Return to Registration Page</a> <br />
        <a href="./index.php">Return to Login Page</a>
        <?php
    }
    else {
        echo "Account successfully created.";
        ?>
        <br /> <br />
        <a href="./index.php">Go To Login</a>
        </td>
        <?php
    }
}

function addUser() {
    $user = $_POST['userid'];
    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $priv = $_POST['private'] ? "true" : "false";
    $lang = $_POST['lang'];
    $bio = $_POST['bio'];
    $loc = $_POST['location'];
    $url = $_POST['url'];
    $bday = $_POST['birthday'];
    
    $result = db_addUser($user, $password, $first, $last, $email, $priv, $lang, $bio, $loc, $url, $bday);
    return $result;
}

?>

<html>

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
    	<?php displaySuccess(); ?>
</div> <!-- End Content Div -->

</body>
</html>