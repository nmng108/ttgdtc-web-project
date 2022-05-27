<?php
$root_dir = "../..";

include_once($root_dir."/database/manager.php");
include_once($root_dir."/includes/utilities.php");

if (!isset($_POST)) exit('input not found');

$item_code = $_POST['item_code']; echo $item_code;
$new_quantity = $_POST['new_quantity'];
$request_number = $_POST['request_number']; echo " " .$request_number;

$query = "SELECT IF(availableQuantity >= $new_quantity, 1, 0) AS isValid
        FROM Products WHERE itemCode = $item_code";
$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

if (count($result) == 1) {
    $result = $result[0]['isValid'];
    if ($result == true) {
        $query = "UPDATE RequestDetails rd JOIN Products p ON rd.itemCode = p.itemCode
                SET quantity = $new_quantity
                WHERE rd.itemCode = $item_code AND availableQuantity >= $new_quantity
                AND requestNumber = $request_number";
        echo run_mysql_query($query);  
    } else {
        echo false;
    }
}
