<?php
//Includes:
include_once("./databaseTools.php");

//DEBUG
//$_SESSION['id'] = 0; //Fake a session
//$_SESSION['username'] = "userA";

//Page-specific
//-------------

//Query the db for the user
$query = "SELECT * "
	   . "FROM users "
	   . "WHERE users.id='".$_SESSION['id']."'";
$result = run_sql($query);
$user = mysql_fetch_array($result);
$id = $user['ID'];
$first = $user['first_name'];
$last = $user['last_name'];
$email = $user['email'];
$private = $user['private'];
$lang = $user['lang'];
$bio = $user['bio'];
$location = $user['location'];
$url = $user['URL'];
$location = $user['birthday'];

function editAccountWidget() {
	global $first, $last, $email, $private, $lang, $bio, $location, $url, $birthday;
    if (isset($_POST['submit'])) {
		$id = $_SESSION['id'];
        $result = updateUser();
        if(!$result) {
            echo "Update was unsuccessful.";
			$first = $_POST['first'];
			$last = $_POST['last'];
			$email = $_POST['email'];
			$priv = $_POST['private'] ? "true" : "false";
			$lang = $_POST['lang'];
			$bio = $_POST['bio'];
			$loc = $_POST['location'];
			$url = $_POST['url'];
			$bday = $_POST['birthday'];
            editForm($first, $last, $email, $private, $lang, $bio, $location, $url, $birthday);
        }
        else {
            echo "Update was successful.";
        }
    }
    else {
        editForm($first, $last, $email, $private, $lang, $bio, $location, $url, $birthday);
    }
}

function updateUser() {
    $id = $_SESSION['id'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $priv = isset($_POST['private']) ? "true" : "false";
    $lang = $_POST['lang'];
    $bio = $_POST['bio'];
    $loc = $_POST['location'];
    $url = $_POST['url'];
    $bday = $_POST['birthday'];
    
    $result = db_updateUser($id, $first, $last, $email, $priv, $lang, $bio, $loc, $url, $bday);
    return $result;
}

function editForm($first, $last, $email, $private, $lang, $bio, $location, $url, $birthday) {
    ?>
    <form method="post" action="<?php $PHP_SELF;?>">
        <pre>
        First Name: <input type="text" name="first" value="<?php echo $first;?>" size="50" />
        Last Name:  <input type="text" name="last" value="<?php echo $last;?>" size="50" />
        E-Mail:     <input type="text" name="email" value="<?php echo $email;?>" size="50" />
        Private:    <input type="checkbox" name="private" value="1" />
        Language:   <input type="text" name="lang" value="<?php echo $lang;?>" size="50" />
        Bio:        <input type="text" name="bio" value="<?php echo $bio;?>" size="50" />
        Location:   <input type="text" name="location" value="<?php echo $location;?>" size="50" />
        URL:        <input type="text" name="url" value="<?php echo $url;?>" size="50" />
        Birthday:   <input type="date" name="birthday" value="<?php echo $birthday;?>" />
                    <input type="submit" value="Submit" name="submit">
        </pre>
    </form>
    <?php
}

?>

<html>

<head>
    <title>User CP</title>
</head>

<body>
    <div id="header">
        <h1>Twitter Project</h1>
    </div>
    
    <div id="content">
    
        <div id="createAccount">
            <h2>Edit Profile:</h2>
            <?php 
                editAccountWidget();
            ?>
        </div>
    </div>
</body>

</html>
    