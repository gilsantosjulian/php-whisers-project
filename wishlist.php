<?php
// Import bootstrap scripts and styles
include('includes/layout.php');
?>

<body class="container p-5">

  <h2 class="text-secondary mb-3">Database Driven Application With PHP</h2>
  <h4 class="mb-4"><span class="label label-default text-secondary">Wish List of <?php echo htmlentities($_GET["user"]); ?></span></h4>

  <?php
  /* This is a function that is getting the wisher ID from the database. */
  $wisherID = WishDB::getInstance()->get_wisher_id_by_name($_GET["user"]);

  /* This is a conditional statement that checks if the user is not found in the database. If the user
  is not found, it will display an error message and a link to go back to the index page. */
  if (!$wisherID) {
    echo "
      <div class='alert alert-danger' role='alert'>
        The person <b>" . $_GET["user"] . "</b> is not found. Please check the spelling and try again
      </div>
      <a href='index.php' class='btn btn-link'><< Back</a>
    ";
    exit();
  }
  ?>
  
  <!-- Making a table -->
  <table class="table table-striped">
    <tr>
      <th class="text-info" scope="col">#</th>
      <th class="text-info" scope="col">Item</th>
      <th class="text-info" scope="col">Due Date</th>
    </tr>
    <?php
    /* This is a while loop that is fetching the results from the database and displaying them in a
    table. */
    $result = WishDB::getInstance()->get_wishes_by_wisher_id($wisherID);
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr>" .
        "<th>" . htmlentities($row["id"]) . "</th>" .
        "<td>" . htmlentities($row["description"]) . "</td>" .
        "<td>" . htmlentities($row["due_date"]) . "</td>" .
        "</tr>";
    }
    mysqli_free_result($result);
    ?>
  </table>

  <a href="index.php" class="btn btn-link"><< Back</a>

</body>

</html>