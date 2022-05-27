<?php
$root_dir = "..";

include_once("../database/manager.php");
include_once("../includes/utilities.php");
include_once("../request/manager.php");

if (!isset($_POST['student_id']) && !isset($_POST['request_number'])) {
    exit("info is not sent by post method");
}

$student_id = $_POST['student_id'];

// Response
$response = [];
$response['message'] = '';
$response['hasSucceeded'] = false;

$result = create_request_details_by_cart($student_id);

if ($result === true) {
    $query = "DELETE FROM Carts
            WHERE userID = $student_id
            AND itemCode IN (SELECT itemCode FROM Products WHERE category = '".SPORT_EQUIPMENT."')";
    $result = run_mysql_query($query);

    if ($result === true) {
        $response['hasSucceeded'] = true;
        $response['message'] = "Successful creating request details.";
    } else {
        $response['message'] = "Successful insertion and Failed deletion";
    }
} else {
    $response['message'] = "Failed insertion";
}

echo json_encode($response);