<?php
// Import bootstrap scripts and styles
include('includes/layout.php');

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
  $wisherID = WishDB::getInstance()->get_wisher_id_by_name($_POST["user"]);

  if ($wisherID) {
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

    WishDB::getInstance()->create_wisher($_POST["user"], $_POST["password"]);

    session_start();
    $_SESSION['user'] = $_POST['user'];

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

<body class="container p-5">
  <h2 class="text-secondary mb-3">Database Driven Application With PHP</h2>
  <h4 class="mb-4"><span class="label label-default text-info">Welcome!</span></h4>

  <!-- Registration form -->
  <form class="mb-3 w-50" name="logon" action="createNewWisher.php" method="POST">
    <div class="mb-3">
      <label for="user" class="form-label text-secondary">Your name:</label>
      <input class="form-control" placeholder="Write the name" type="text" name="user" id="user">
      <!-- Username has to be filled out and cannot be a duplicate -->
      <?php
      if ($userIsEmpty) {
        echo "
        <div class='invalid-feedback' style='display: block;'>
          Enter your name, please!.
        </div>";
      }
      if (!$userNameIsUnique) {
        echo "
        <div class='invalid-feedback' style='display: block;'>
          The person already exists. Please check the spelling and try again.
        </div>";
      }
      ?>
    </div>

    <!-- Password cannot be empty -->
    <div class="mb-3">
      <label for="user" class="form-label text-secondary">Password:</label>
      <input class="form-control" placeholder="Write the password" type="password" name="password" id="password">
      <?php
      if ($passwordIsEmpty) {
        echo "
        <div class='invalid-feedback' style='display: block;'>
          Enter the password, please!.
        </div>";
      }
      ?>
    </div>

    <!-- Password confirmation needs to be filled and match previous password input -->
    <div class="mb-3">
      <label for="user" class="form-label text-secondary">Please confirm your password:</label>
      <input class="form-control" placeholder="Please confirm the password" type="password" name="password2" id="password2">
      <?php
      if ($password2IsEmpty) {
        echo "
        <div class='invalid-feedback' style='display: block;'>
          Confirm your password, please.
        </div>";
      }
      /* This is checking if the password is empty and if the password is valid. If it is not empty and
      not valid, then it will display the error message. */
      if (!$password2IsEmpty && !$passwordIsValid) {
        echo "
        <div class='invalid-feedback' style='display: block;'>
          The passwords do not match!.
        </div>";
      }
      ?>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>

  <a href='index.php' class='btn btn-link'>
    << Back</a>
</body>

</html>