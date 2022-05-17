<?php
$root_dir = "..";

include_once("$root_dir/database/manager.php");

function get_cart_info(int $user_id) {
    $query = "SELECT c.itemCode, itemName, primaryImage, category, quantity FROM Carts c JOIN Products p ON c.itemCode = p.itemCode WHERE $user_id = c.userID";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result;
    }

    return NULL;
}

function add_item_to_cart(int $user_id, int $item_code, int $quantity) {
    $query = "INSERT INTO `Carts` VALUES ($user_id, $item_code, $quantity)";
    return run_mysql_query($query);
}

function update_quantity(int $user_id, int $item_code, int $new_quantity) {
    $query = "UPDATE `Carts` SET `quantity` = '$new_quantity' WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}

function increase_quantity(int $user_id, int $item_code, int $added_quantity) {
    $query = "UPDATE `Carts` SET `quantity` = `quantity` + $added_quantity WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}

function delete_item_from_cart(int $user_id, int $item_code) {
    $query = "DELETE FROM `Carts` WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}