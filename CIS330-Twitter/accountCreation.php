<?php
//Includes:
include_once("./databaseTools.php");

function newAccountWidget() {
    if (isset($POST['submit'])) {
        $result = addUser();
        if(!$result) {
            echo "Account creation was unsuccessful.";
            //createAccountForm();
        }
        else {
            echo "Account creation was successful.";
        }
    }
    else {
        createAccountForm();
    }
}

function addUser() {
    $user = $_POST['userid'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $priv = $_POST['private'] ? "true" : "false";
    $lang = $_POST['lang'];
    $bio = $_POST['bio'];
    $loc = $_POST['location'];
    $url = $_POST['url'];
    $bday = $_POST['birthday'];
    
    $result = db_addUser($user, $first, $last, $email, $priv, $lang, $bio, $loc, $url, $bday);
    return $result;
}

function createAccountForm() {
    ?>
    <form method="post" action="<?php $PHP_SELF;?>">
        <pre>
        User ID:    <input type="text" name="userid" value="Max 20 chars." size="20" onfocus="value=" />
        First Name: <input type="text" name="first" size="50" />
        Last Name:  <input type="text" name="last" size="50" />
        E-Mail:     <input type="text" name="email" size="50" />
        Private:    <input type="checkbox" name="private" value="1" />
        Language:   <input type="text" name="lang" size="50" />
        Bio:        <input type="text" name="bio" size="50" />
        Location:   <input type="text" name="location" size="50" />
        URL:        <input type="text" name="url" size="50" />
        Birthday:   <input type="date" name="birthday" />
                    <input type="submit" />
        </pre>
    </form>
    <?php
}

?>

<html>

<head>
    <title>Account Creation</title>
</head>

<body>
    <div id="header">
        <h1>Twitter Project</h1>
    </div>
    
    <div id="content">
    
        <div id="createAccount">
            <h2>Create New Account:</h2>
            <?php 
                createAccountForm();
            ?>
        </div>
    </div>
</body>

</html>
    