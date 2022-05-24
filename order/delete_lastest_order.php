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


$query = "DELETE FROM Orders 
        WHERE orderNumber = (SELECT MAX(orderNumber) FROM Orders WHERE studentID = $student_id)";
$result = run_mysql_query($query);

if ($result === true) {
    $response['hasSucceeded'] = true;
    $response['message'] = "Successful deletion";
} else {
    $response['message'] = "Failed deletion";
}

echo json_encode($response);
