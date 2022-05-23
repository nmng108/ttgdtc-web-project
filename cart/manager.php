<?php
include_once("$root_dir/database/manager.php");

// unused
function get_cart_info(int $user_id) {
    $query = "SELECT c.itemCode, itemName, primaryImage, quantity, availableQuantity FROM Carts c JOIN Products p ON c.itemCode = p.itemCode WHERE $user_id = c.userID ORDER BY category ";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result;
    }

    return NULL;
}

// Used in cart
function get_cart_info_by_category(int $user_id, string $category) {
    if ($category === SPORT_EQUIPMENT) {
        $query = "SELECT c.itemCode, itemName, primaryImage, quantity, availableQuantity FROM Carts c JOIN Products p ON c.itemCode = p.itemCode WHERE $user_id = c.userID AND category = '$category'";
        $result = run_mysql_query($query);
        
        if ($result !== false) {
            return $result;
        }
    } else if ($category === UNIFORM) {
        $query = 
            "SELECT c.itemCode, itemName, primaryImage, c.type AS size, c.quantity AS quantity, us.quantity AS availableQuantity, priceEach
            FROM Carts c JOIN Products p ON c.itemCode = p.itemCode 
            JOIN Uniforms u ON c.itemCode = u.itemCode 
            JOIN UniformSizes us ON (c.itemCode = us.itemCode AND c.type = us.size)
            WHERE $user_id = c.userID AND category = '$category'";
        $result = run_mysql_query($query);
        
        if ($result !== false) {
            return $result;
        }
    }

    return NULL;
}

// Used in add_to_cart.php for the main page purpose.
function add_new_to_cart(int $user_id, int $item_code, $size, int $quantity) {
    if (isset($size)) {
        $quantity_in_inventory = get_quantity_in_inventory_by_size($item_code, $size);
        // if the condition below is false then return the number of this item in the inventory.
        if ($quantity_in_inventory !== NULL
                && $quantity > $quantity_in_inventory) {
            return false;
        }

        $query = "INSERT INTO `Carts`(`userID`, `itemCode`, `quantity`, `type`) VALUES ($user_id, $item_code, $quantity, '$size')";
    } else {
        $quantity_in_inventory = get_quantity_in_inventory($item_code);
        // if the condition below is false then return the number of this item in the inventory.
        if ($quantity_in_inventory !== NULL
                && $quantity > $quantity_in_inventory) {
            return false;
        }

        $query = "INSERT INTO `Carts`(`userID`, `itemCode`, `quantity`) VALUES ($user_id, $item_code, $quantity)";
    }
    return run_mysql_query($query);
}

// Used in add_to_cart.php for the main page purpose.
function increase_quantity(int $user_id, int $item_code, $size, int $added_quantity) {
    // UNIFORM
    if (isset($size)) {
        $query = "SELECT quantity FROM Carts WHERE `itemCode` = $item_code AND `userID` = $user_id AND `type` = '$size'";
        $result = run_mysql_query($query);
    
        if ($result->num_rows == 1) {
            $quantity_in_cart = mysqli_fetch_array($result)['quantity'];
            
            $quantity_in_inventory = get_quantity_in_inventory_by_size($item_code, $size);
            // if the condition below is false then return the number of this item in the inventory.
            if ($quantity_in_inventory !== NULL) {
                if ($quantity_in_inventory < $added_quantity) {
                    return false;    
                }
                if ($quantity_in_cart + $added_quantity > $quantity_in_inventory) {
                    return $quantity_in_cart;
                }
            }
        }
        // final query
        $query = "UPDATE `Carts` SET `quantity` = `quantity` + $added_quantity WHERE `itemCode` = $item_code AND `userID` = $user_id AND `type` = '$size'";

    // SPORT_EQUIPMENT
    } else {
        $query = "SELECT quantity FROM Carts WHERE `itemCode` = $item_code AND `userID` = $user_id";
        $result = run_mysql_query($query);
    
        if ($result->num_rows == 1) {
            $quantity_in_cart = mysqli_fetch_array($result)['quantity'];
            
            $quantity_in_inventory = get_quantity_in_inventory($item_code);
            // if the condition below is false then return the number of this item in the inventory.
            if ($quantity_in_inventory !== NULL) {
                if ($quantity_in_inventory < $added_quantity) {
                    return false;
                }
                if ($quantity_in_cart + $added_quantity > $quantity_in_inventory) {
                    return $quantity_in_cart;
                }
            }
        }
        // final query
        $query = "UPDATE `Carts` SET `quantity` = `quantity` + $added_quantity WHERE `itemCode` = $item_code AND `userID` = $user_id";
    }

    // return true when adding to cart is successful;
    return run_mysql_query($query);
}

/**
 * @todo: edit this 2 functions
 */
// Used in cart
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

// Used in cart
function delete_item_from_cart(int $user_id, int $item_code) {
    $query = "DELETE FROM `Carts` WHERE `itemCode` = $item_code AND `userID` = $user_id";
    return run_mysql_query($query);
}