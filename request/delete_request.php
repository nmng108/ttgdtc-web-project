<?php
$root_dir = "..";

include_once("../database/manager.php");
include_once("../includes/utilities.php");
include_once("../request/manager.php");

$response = [];
$response['hasSucceeded'] = false;
$responde['message'] = '';

if (!isset($_POST['request_number'])) {
    $responde['message'] = 'request_number is not set';
    echo json_encode($response);
}

if (delete_request($_POST['request_number'])) {
    $response['hasSucceeded'] = true;
    $responde['message'] = 'deleted successfully';
    echo json_encode($response);
} else {
    $responde['message'] = 'fail deletion';
    echo json_encode($response);
}
