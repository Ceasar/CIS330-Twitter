<?php

function createAccountForm() {
    ?>
    <form name="accountcreate" method="post" action="./createSuccess.php">
        <pre>
        User ID:    <input type="text" name="userid" value="Max 20 chars." size="20" onfocus="value=''" />
        Password:   <input type="password" name="password" />
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

<?php include_once("./assets/templates/head.php");?>

<body>

<?php include_once("./assets/templates/header.php");?>

<!-- Unique page content goes here. -->
<div id="content">
    	<?php createAccountForm(); ?>
</div> <!-- End Content Div -->

</body>
</html>
    