<?php
session_start();

$root_dir = "..";

include_once($root_dir."/cart/manager.php");
include_once($root_dir."/includes/utilities.php");

if (isset($_POST['item_code']) && isset($_SESSION[USERID])) {
    $return_array = array();
    $category = null;

    $query = "SELECT category FROM Products WHERE itemCode = ".$_POST['item_code'];
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        $category = $result->fetch_array()['category'];
    }

    $query = "SELECT count(*) total, category 
        FROM Carts c JOIN Products p ON c.itemCode = p.itemCode 
        WHERE userID = ".$_SESSION[USERID]." AND category = (SELECT category FROM Products WHERE itemCode = ".$_POST['item_code'].")";
    // $query = "SELECT count(*) total, category 
    //     FROM Carts c JOIN Products p ON (c.itemCode = p.itemCode AND c.itemCode = ".$_POST['item_code']
    //     .") WHERE userID = ".$_SESSION[USERID];
    
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        $return_array = $result->fetch_array();
    } else {
        echo "nothing";
    }

    $query = "DELETE FROM Carts WHERE itemCode = ".$_POST['item_code']." AND userID = ".$_SESSION[USERID];
    $result = run_mysql_query($query);
    if ($result == false) exit("Cannot delete the item.");
    else {
        $return_array['total'] -= 1;
        echo json_encode($return_array);
    }
}