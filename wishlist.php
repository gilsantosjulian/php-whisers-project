<?php
// Import bootstrap scripts and styles
include('./layout.php');

// Include config file
require_once "./config.php";
?>

<body class="container p-5">

  <h2 class="pull-left">Wish List of</h2>
  <?php 
    echo htmlentities($_GET["user"]) . "<br/>";

    $user = mysqli_real_escape_string($connection, htmlentities($_GET["user"]));

    $sql = "SELECT id, name, password FROM wishers WHERE name='" . $user . "'";

    if ($result = mysqli_query($connection, $sql)) {
      if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>name</th>";
        echo "<th>password</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['password'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        // Close result set
        mysqli_free_result($result);
      } else {
        echo "No records matching your query were found.";
      }
    } else {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);
  ?>

</body>

</html>