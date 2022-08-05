<?php
// Import bootstrap scripts and styles
include('./layout.php');
?>

<body class="container p-5">
  <input type="submit" name="showWishList" value="Show Wish List of" onclick="javascript:showHideShowWishListForm()" />
  <form class="container px-0 mb-5" action="wishlist.php" method="GET" name="wishList" style="visibility:hidden">
    <div class="input-group-md mb-3 w-50">
      <label for="user" class="form-label text-secondary">Show wish list of:</label>
      <input class="form-control mb-3" placeholder="Please write the input" type="text" name="user" id="user">
      <button type="submit" class="btn btn-primary">Go</button>
    </div>
  </form>
  <br>
  <p><em>Still don't have a wish list?!</em></p>
  <a href="createNewWisher.php"><button class="btn btn-primary">Create one now!</button></a>

  <input type="submit" name="myWishList" value="My Wishlist" onclick="javascript:showHideLogonForm()" />
  <form name="logon" action="index.php" method="POST" style="visibility:<?php if ($logonSuccess) echo "hidden";
                                                                        else echo "visible"; ?>">
    Username: <input type="text" name="user">
    Password <input type="password" name="userpassword">
    <input type="submit" value="Edit My Wish List">
  </form>
</body>
<?php
require_once("Includes/db.php");
$logonSuccess = false;

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $logonSuccess = (WishDB::getInstance()->verify_wisher_credentials($_POST['user'], $_POST['userpassword']));
  if ($logonSuccess == true) {
    session_start();
    $_SESSION['user'] = $_POST['user'];
    header('Location: editWishList.php');
    exit;
  } else {
    echo "Invalid name and/or password";
  }
}
?>
<script>
  function showHideLogonForm() {
    if (document.all.logon.style.visibility == "visible") {
      document.all.logon.style.visibility = "hidden";
      document.all.myWishList.value = "My Wishlist >>";
    } else {
      document.all.logon.style.visibility = "visible";
      document.all.myWishList.value = "<< My Wishlist";
    }
  }

  function showHideShowWishListForm() {
    if (document.all.wishList.style.visibility == "visible") {
      document.all.wishList.style.visibility = "hidden";
      document.all.showWishList.value = "Show Wish List of >>";
    } else {
      document.all.wishList.style.visibility = "visible";
      document.all.showWishList.value = "<< Show Wish List of";
    }
  }
</script>

</html>