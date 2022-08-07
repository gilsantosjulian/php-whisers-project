<?php 
require_once("includes/db.php");
/* Deleting the wish from the database and then redirecting the user to the editWishList.php page. */
WishDB::getInstance()->delete_wish ($_POST["wishID"]);
header('Location: editWishList.php' );
