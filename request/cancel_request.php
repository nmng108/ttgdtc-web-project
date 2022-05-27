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

if (cancel_request($_POST['request_number'])) {
    $response['hasSucceeded'] = true;
    $responde['message'] = 'canceled successfully';
    echo json_encode($response);
}
