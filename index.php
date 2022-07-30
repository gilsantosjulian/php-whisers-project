<?php
// Import bootstrap scripts and styles
include('./layout.php');
?>

<body class="container p-5">
  <form class="container px-0 mb-5" action="wishlist.php" method="GET" name="wishList">
    <div class="input-group-md mb-3 w-50">
      <label for="user" class="form-label text-secondary">Show wish list of:</label>
      <input class="form-control mb-3" placeholder="Please write the input" type="text" name="user" id="user">
      <button type="submit" class="btn btn-primary">Go</button>
    </div>
  </form>
</body>

</html>