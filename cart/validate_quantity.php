<?php
$root_dir = "..";

include_once("$root_dir/database/manager.php");

if (isset($_POST['item_code'])) {
    $query = "SELECT availableQuantity FROM Products WHERE itemCode = ".$_POST['item_code'];
    if (($result = run_mysql_query($query)) !== false) {
        $result = $result->fetch_array()['availableQuantity'];
        echo $result;
    }
}