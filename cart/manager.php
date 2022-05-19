<?php
$root_dir = "..";
include_once("$root_dir/database/manager.php");

define('SPORT_EQUIPMENT', 'SPORT EQUIPMENT');
define('UNIFORM', 'UNIFORM');

//get all information in cart, which is sorted by category, of the current user.
function get_cart_info(int $user_id) {
    $query = "SELECT c.itemCode, itemName, primaryImage, quantity, availableQuantity, category FROM Carts c JOIN Products p ON c.itemCode = p.itemCode WHERE $user_id = c.userID ORDER BY category ";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result;
    }

    return NULL;
}

function get_cart_info_by_category(int $user_id, string $category) {
    $query = "SELECT c.itemCode, itemName, primaryImage, quantity, availableQuantity FROM Carts c JOIN Products p ON c.itemCode = p.itemCode WHERE $user_id = c.userID AND category = '$category'";
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
    $query = "SELECT availableQuantity FROM Products WHERE `itemCode` = $item_code";
    $result = run_mysql_query($query);

    if ($result->num_rows == 1) {
        $quantity_in_inventory = mysqli_fetch_array($result)['availableQuantity'];
        
        if ($new_quantity > $quantity_in_inventory) {
            return false;
        }
    }

    $query = "UPDATE `Carts` SET `quantity` = '$new_quantity' WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}

function increase_quantity(int $user_id, int $item_code, int $added_quantity) {
    $query = "SELECT quantity FROM Carts WHERE `itemCode` = $item_code AND `userID` = $user_id";
    $result = run_mysql_query($query);

    if ($result->num_rows == 1) {
        $quantity_in_cart = mysqli_fetch_array($result)['quantity'];
        
        $query = "SELECT availableQuantity FROM Products WHERE `itemCode` = $item_code";
        $result = run_mysql_query($query);

        if ($result->num_rows == 1) {
            $quantity_in_inventory = mysqli_fetch_array($result)['availableQuantity'];
            // if the condition below is false then return the number of this item in the inventory.
            if ($quantity_in_cart + $added_quantity > $quantity_in_inventory) {
                return $quantity_in_cart;
            }
        }
    }

    $query = "UPDATE `Carts` SET `quantity` = `quantity` + $added_quantity WHERE `itemCode` = $item_code AND `userID` = $user_id";
    // return true when adding to cart is successful;
    return run_mysql_query($query);
}

function delete_item_from_cart(int $user_id, int $item_code) {
    $query = "DELETE FROM `Carts` WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}