<?php
$root_dir = "..";

include_once("../database/manager.php");
include_once("../includes/utilities.php");

if (!isset($_POST['student_id']) && !isset($_POST['order_number'])) {
    exit("info is not sent by post method");
}

$student_id = $_POST['student_id'];

// Response
$response = [];
$response['message'] = '';
$response['hasSucceeded'] = false;

$query = "INSERT INTO OrderDetails (orderNumber, itemCode, size, quantity)
        SELECT ".$_POST['order_number'].", c.itemCode, type, quantity
        FROM Carts c JOIN Products p ON c.itemCode = p.itemCode
        WHERE category = '".UNIFORM."'";
$result = run_mysql_query($query);

if ($result === true) {
    $query = "DELETE FROM Carts
            WHERE userID = ".$_POST['student_id']."
            AND itemCode IN (SELECT itemCode FROM Products WHERE category = '".UNIFORM."')";
    $result = run_mysql_query($query);

    if ($result === true) {
        $response['hasSucceeded'] = true;
        $response['message'] = "Successful insertion";
    } else {
        $response['message'] = "Successful insertion and Failed deletion";
    }
} else {
    $response['message'] = "Failed insertion";
}

echo json_encode($response);