<?php
session_start();

$root_dir = "..";
include_once('./manager.php');
include_once('../includes/utilities.php');

if (isset($_POST['item_code']) && isset($_SESSION[USERID])) {
    $query = "DELETE FROM Carts WHERE itemCode = ".$_POST['item_code']." AND userID = ".$_SESSION[USERID];
    $result = run_mysql_query($query);
    if ($result == false) exit("Cannot delete the item.");
}