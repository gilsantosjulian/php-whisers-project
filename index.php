<?php
// Import bootstrap scripts and styles
include('includes/layout.php');
?>

<body class="container p-5">

  <h2 class="text-secondary mb-3">Database Driven Application With PHP</h2>

  <div id="accordionOne" class="mb-5">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0 panel-title">
          <a class="btn btn-link text-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Show list of
          </a>
        </h5>
      </div>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionOne">
        <div class="card card-body">
          <form class="container px-0 mb-5" action="wishlist.php" method="GET" name="wishList">
            <div class="input-group-md mb-3 w-50">
              <label for="user" class="form-label text-secondary">Show wish list of specific wisher:</label>
              <input class="form-control mb-3" placeholder="Please write the wisher name" type="text" name="user" id="user">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="mb-5">
    <!-- <p><em>Still don't have a wish list?!</em></p> -->
    <div class="alert alert-info" role="alert">
      Still don't have a wish list?!
    </div>
    <a href="createNewWisher.php"><button class="btn btn-primary">Create one now!</button></a>
  </div>



  <div id="accordionTwo" class="mb-5">
    <div class="card">
      <div class="card-header" id="headingTwo">
        <h5 class="mb-0 panel-title">
          <a class="btn btn-link text-info" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            My Wishlist
          </a>
        </h5>
      </div>

      <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionTwo">
        <div class="card card-body">
          <form name="logon" action="index.php" method="POST" style="visibility:
                <?php
                if ($logonSuccess) echo "hidden";
                else echo "visible";
                ?>">

            <label for="user" class="form-label text-secondary">Username:</label>
            <input class="form-control mb-3" placeholder="Please write the username" type="text" name="user" id="user">

            <label for="user" class="form-label text-secondary">Password:</label>
            <input class="form-control mb-3" placeholder="Please write the password" type="password" name="userpassword" id="password">

            <button type="submit" class="btn btn-secondary">Edit My Wish List</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
<?php
$logonSuccess = false;

// Verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $logonSuccess = (WishDB::getInstance()->verify_wisher_credentials($_POST['user'], $_POST['userpassword']));
  if ($logonSuccess == true) {
    session_start();
    $_SESSION['user'] = $_POST['user'];
    header('Location: editWishList.php');
    exit;
  } else {
    echo '<div class="alert alert-danger"><em>Invalid name and/or password.</em></div>';
  }
}
?>

</html>