<?php
$root_dir = "../..";

include_once($root_dir."/database/manager.php");
include_once($root_dir."/includes/utilities.php");

$response = array();
$response['hasSucceeded'] = false;
$response['message'] = "";

if (isset($_POST['item_code']) && isset($_POST['request_number'])) {
    // count the number of items (not quantity)
    $query = "SELECT count(*) itemCount
        FROM RequestDetails rd JOIN Products p ON rd.itemCode = p.itemCode 
        WHERE requestNumber = ".$_POST['request_number'];
    
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        $response['itemCount'] = $result->fetch_array()['itemCount'];
    } else {
        $response['message'] = "error query1";
        echo json_encode($response);
        exit();
    }

    $query = "DELETE FROM RequestDetails 
            WHERE itemCode = ".$_POST['item_code']." 
            AND requestNumber = ".$_POST['request_number'];
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
    $response['message'] = "not received enough input";
    echo json_encode($response);
}