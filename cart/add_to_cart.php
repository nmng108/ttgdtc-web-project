<?php
session_start();

$root_dir = "..";
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");
include_once("$root_dir/cart/manager.php");

if (isset($_POST['quantity']) && isset($_POST['item_code']) && isset($_SESSION[USERID])) {
    
    $result = get_data_from_all_columns("Carts", "`itemCode` = ".$_POST['item_code']." AND `userID` = ".$_SESSION[USERID]);

    if ($result->num_rows == 1) {
        $result = increase_quantity($_SESSION[USERID], $_POST['item_code'], $_POST['quantity']);
        if ($result === true) {
            echo "Thêm thành công";
        } else {
            echo "Thêm thất bại. Trong giỏ đang chứa ". $result;
        }
    } else if (add_item_to_cart($_SESSION[USERID], $_POST['item_code'], $_POST['quantity']) == true) {
        echo "Thêm thành công";

} else { 
    echo "Thêm thất bại";
}
} else {
    echo "Thêm thất bại";
}