<?php
// Import bootstrap scripts and styles
include('./layout.php');

// Include config file
require_once "./config.php";

/** other variables */
$userNameIsUnique = true;
$passwordIsValid = true;
$userIsEmpty = false;
$passwordIsEmpty = false;
$password2IsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    /** Check whether the user has filled in the wisher's name in the text field "user" */
    if ($_POST['user'] == "") {
        $userIsEmpty = true;
    }

    /** Check whether a user whose name matches the "user" field already exists */
    mysqli_select_db($connection, "wishlist");
    $user = mysqli_real_escape_string($connection, $_POST['user']);
    $wisher = mysqli_query($connection, "SELECT id FROM wishers WHERE name='".$user."'");
    $wisherIDnum=mysqli_num_rows($wisher);
    if ($wisherIDnum) {
        $userNameIsUnique = false;
    }

    /** Check whether a password was entered and confirmed correctly */
    if ($_POST['password'] == "") {
        $passwordIsEmpty = true;
    }
    if ($_POST['password2'] == "") {
        $password2IsEmpty = true;
    }
    if ($_POST['password'] != $_POST['password2']) {
        $passwordIsValid = false;
    }

    /** Check whether the boolean values show that the input data was validated successfully.
     * If the data was validated successfully, add it as a new entry in the "wishers" database.
     * After adding the new entry, close the connection and redirect the application to editWishList.php.
     */
    if (!$userIsEmpty && $userNameIsUnique && !$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        mysqli_select_db($connection, "wishlist");
        mysqli_query($connection, "INSERT wishers (name, password) VALUES ('" . $user . "', '" . $password . "')");
        mysqli_free_result($wisher);
        mysqli_close($connection);
        header('Location: editWishList.php');
        exit;
    }
}
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>Welcome!<br>
    <form action="createNewWisher.php" method="POST">
        Your name: <input type="text" name="user"/><br/>
        <?php
            if ($userIsEmpty) {
                echo ("Enter your name, please!");
                echo ("<br/>");
            }
            if (!$userNameIsUnique) {
                echo ("The person already exists. Please check the spelling and try again");
                echo ("<br/>");
            }
        ?>
        Password: <input type="password" name="password"/><br/>
        <?php
            if ($passwordIsEmpty) {
            echo ("Enter the password, please!");
            echo ("<br/>");
            }
        ?>
        Please confirm your password: <input type="password" name="password2"/><br/>
        <?php
            if ($password2IsEmpty) {
                echo ("Confirm your password, please");
                echo ("<br/>");
            }
           if (!$password2IsEmpty && !$passwordIsValid) {
                echo  ("The passwords do not match!");
                echo ("<br/>");
            }
        ?>
        <input type="submit" value="Register"/>
    </form>
    </body>
</html>