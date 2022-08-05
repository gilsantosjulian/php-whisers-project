<?php 
require_once("includes/db.php");
WishDB::getInstance()->delete_wish ($_POST["wishID"]);
header('Location: editWishList.php' );
