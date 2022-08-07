<?php
// Import bootstrap scripts and styles
include('includes/layout.php');

?>

<body class="container p-5">

  <h2 class="text-secondary mb-3">Database Driven Application With PHP</h2>

  <div class="edit_wish_content-top">
    <h4 class="mb-4">
      <?php session_start();
      /* This is checking if the user is logged in. If not, it redirects to the login page. */
      if (array_key_exists("user", $_SESSION)) {
        echo "<span class='label label-default text-info'>Hello " . $_SESSION['user'] . "</span>";
      } else {
        header('Location: index.php');
        exit;
      } ?>
    </h4>
    <!-- Button to add a new wish to the list -->
    <form name="addNewWish" action="editWish.php">
      <button type="submit" class="btn btn-primary">Add Wish</button>
    </form>
  </div>

  <!-- Table with list of wishes, and actions user can perform -->
  <table class="table table-striped">
    <tr>
      <th class="text-info" scope="col">#</th>
      <th class="text-info" scope="col">Item</th>
      <th class="text-info" scope="col">Due Date</th>
      <th class="text-info">Actions</th>
    </tr>

    <?php
    /* This is getting the wisherID from the database and then using that to get the wishes from the
    database. */
    $wisherID = WishDB::getInstance()->get_wisher_id_by_name($_SESSION["user"]);
    $result = WishDB::getInstance()->get_wishes_by_wisher_id($wisherID);

    /* This is a while loop that is looping through the results of the query. */
    while ($row = mysqli_fetch_array($result)) :
      echo "<tr>" .
        "<th>" . htmlentities($row["id"]) . "</th>" .
        "<td>" . htmlentities($row["description"]) . "</td>" .
        "<td>" . htmlentities($row["due_date"]) . "</td>";
      $wishID = $row["id"];
    ?>

      <td class="actions-box">
        <!-- Buton to edit wish -->
        <form name="editWish" action="editWish.php" method="GET">
          <input type="hidden" name="wishID" value="<?php echo $wishID; ?>" />
          <button type="submit" class="btn btn-info">Edit</button>
        </form>
        <!-- Button to delete wish -->
        <form name="deleteWish" action="deleteWish.php" method="POST">
          <input type="hidden" name="wishID" value="<?php echo $wishID; ?>" />
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </td>

    <?php
      echo "</tr>\n";
    endwhile;
    mysqli_free_result($result);
    ?>

  </table>

  <a href="index.php" class="btn btn-link"><< Back to the main page</a>

  </body>

</html>