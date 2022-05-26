<?php
session_start();

$root_dir = "..";

include_once($root_dir."/cart/manager.php");
include_once($root_dir."/includes/utilities.php");

$response = array();
$response['hasSucceeded'] = false;
$response['message'] = "";

if (isset($_POST['item_code']) && isset($_SESSION[USERID])) {
    // count the number of items (not quantity) belong to the same category and get category of the item
    $query = "SELECT count(*) itemCount, category
        FROM Carts c JOIN Products p ON c.itemCode = p.itemCode 
        WHERE userID = ".$_SESSION[USERID]." AND category = (SELECT category FROM Products WHERE itemCode = ".$_POST['item_code'].")";
    $result = run_mysql_query($query);
    
    if ($result->num_rows == 1) {
        $result = $result->fetch_array();
        $response['itemCount'] = $result['itemCount'];
        $response['category'] = $result['category'];
    } else {
        $response['message'] = "error query1";
        echo json_encode($response);
    }

    $query = "DELETE FROM Carts 
            WHERE itemCode = ".$_POST['item_code']." AND userID = ".$_SESSION[USERID];
    $result = run_mysql_query($query);
    
    if ($result == false) {
        $response['message'] = "Cannot delete the item.";
        echo json_encode($response);
    } else {
        $response['itemCount'] -= 1;
        $response['hasSucceeded'] = true;
        echo json_encode($response);
    }
} else {
    echo json_encode($response);
}