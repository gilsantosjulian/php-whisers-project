<?php
// Import bootstrap scripts and styles
include('./layout.php');

// Include config file
require_once("./Includes/db.php");
?>

<body class="container p-5">

  <h2 class="pull-left">
    Wish List of <?php echo htmlentities($_GET["user"]) . "<br/>"; ?>
  </h2>
  <?php
  $wisherID = WishDB::getInstance()->get_wisher_id_by_name($_GET["user"]);

  if (!$wisherID) {
    exit("The person <b>" . $_GET["user"] . "</b> is not found. Please check the spelling and try again");
  }
  ?>
  <table border="black">
    <tr>
      <th>Item</th>
      <th>Due Date</th>
    </tr>
    <?php
    $result = WishDB::getInstance()->get_wishes_by_wisher_id($wisherID);
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr><td>" . htmlentities($row["description"]) . "</td>";
      echo "<td>" . htmlentities($row["due_date"]) . "</td></tr>\n";
    }
    mysqli_free_result($result);
    ?>
  </table>
</body>

</html>