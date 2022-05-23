<?php
session_start();

$root_dir = "..";

include_once($root_dir."/cart/manager.php");
include_once($root_dir."/includes/utilities.php");

if (isset($_POST['item_code']) && isset($_POST['new_quantity']) && isset($_SESSION[USERID])) {
    $query = "UPDATE Carts SET quantity = ".$_POST['new_quantity']." WHERE itemCode = ".$_POST['item_code']." AND userID = ".$_SESSION[USERID];
    echo "<script>console.log(".$query.")</script>";

    $result = run_mysql_query($query);
    if ($result == false) die("Cannot update the item quantity.");
}