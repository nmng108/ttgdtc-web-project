<?php
/**
 * Called by the main page for adding items to cart.
 */
session_start();

$root_dir = "..";

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");
include_once("$root_dir/cart/manager.php");

if (isset($_POST['quantity']) && isset($_POST['item_code']) && isset($_SESSION[USERID])) {
    // If the item belongs to UNIFORM, we will pass $_POST['size'] as an argument to 1 of 2 functions below.
    if ($_POST['category'] == UNIFORM) {
        // find if the item already exists in cart or not
        $result = get_data_from_all_columns("Carts", "`itemCode` = ".$_POST['item_code']." AND `userID` = '".$_SESSION[USERID]."' AND `type` = '".$_POST['size']."'");
        
        if ($result->num_rows == 1) {
            $result = increase_quantity($_SESSION[USERID], $_POST['item_code'], $_POST['size'], $_POST['quantity']);
            if ($result === true) {
                echo '<h5 style="size: 8px; color: yellow;" >Thêm thành công</h5>';
            } else if ($result === false) {
                echo '<h5 style="size: 8px; color: red;" >*Thêm thất bại</h5>';
            } else {
                echo "*Thêm thất bại. Trong giỏ đang chứa:". $result;
            }
        } else if (add_new_to_cart($_SESSION[USERID], $_POST['item_code'], $_POST['size'], $_POST['quantity']) == true) {
            echo '<h5 style="size: 8px; color: yellow;" >Thêm thành công</h5>';
        } else { 
            echo '<h5 style="size: 8px; color: red;" >*Thêm thất bại</h5>';
        }
    // If the item belongs to SPORT_EQUIPMENT, we will pass NULL to the parameter $size.
    } else if ($_POST['category'] == SPORT_EQUIPMENT) {
        // find if the item already exists in cart or not
        $result = get_data_from_all_columns("Carts", "`itemCode` = ".$_POST['item_code']." AND `userID` = ".$_SESSION[USERID]);
        
        if ($result->num_rows == 1) {
            $result = increase_quantity($_SESSION[USERID], $_POST['item_code'], NULL, $_POST['quantity']);
            if ($result === true) {
                echo '<h5 style="size: 8px; color: yellow;" >Thêm thành công</h5>';
            } else if ($result === false) {
                echo '<h5 style="size: 8px; color: red;" >*Thêm thất bại</h5>';
            } else {
                echo "Thêm thất bại. Trong giỏ đang chứa ". $result;
            }
        } else if (add_new_to_cart($_SESSION[USERID], $_POST['item_code'], NULL, $_POST['quantity']) == true) {
            echo '<h5 style="size: 8px; color: yellow;" >Thêm thành công</h5>';
        } else { 
            echo '<h5 style="size: 8px; color: red;" >*Thêm thất bại</h5>';
        }
    }
} else {
    echo '<h5 style="size: 8px; color: red;" >*Thêm thất bại</h5>';
}