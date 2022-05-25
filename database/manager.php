<?php
include_once("$root_dir/includes/utilities.php");

include_once('config.php');
define('UPLOADED_IMAGE_DIR', "$root_dir/uploads/images/");


function get_db_connection() {
    $connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    return $connection ? $connection : die("Connection failed: " . mysqli_connect_error());
}

function run_mysql_query(string $query) {
    $connection = get_db_connection();
    
    $query = str_replace("\\", "", $query);
	mysqli_set_charset($connection, 'utf8mb4');
    $result = mysqli_query($connection, $query);
    
    mysqli_close($connection);

    return $result;
}

function get_data_from_all_columns(string $table_name, string $condition = NULL, string $order_by = NULL, $order = ASCENDING) {
    $connection = get_db_connection();

    $table_name = is_null_or_empty_string($table_name) ? "" : trim(mysqli_real_escape_string($connection, $table_name));
    $condition = is_null_or_empty_string($condition) ? "" : trim(mysqli_real_escape_string($connection, $condition));
    $order_by = is_null_or_empty_string($order_by) ? "" : trim(mysqli_real_escape_string($connection, $order_by));
    $order = is_null_or_empty_string($order) ? "" : trim(mysqli_real_escape_string($connection, $order));

    mysqli_close($connection);

    if (($order != ASCENDING && $order != DESCENDING)
            || is_null_or_empty_string($table_name)) {
        return NULL;
    }

    if (is_null_or_empty_string($order_by)) { 
        $query = "SELECT * FROM $table_name WHERE $condition";
    } else {
        $query = "SELECT * FROM $table_name WHERE $condition ORDER BY $order_by $order";
    }
    
    $result = run_mysql_query($query);
    if ($result !== false) {
        return $result;
    }
    
    return NULL;
}

function get_products_by_category(string $category) {
    if ($category == SPORT_EQUIPMENT) {
        $result = get_data_from_all_columns("Products", "`category` = 'SPORT_EQUIPMENT'");
        if ($result !== false) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    } 
    
    if ($category == UNIFORM) {
        $query = 
            "SELECT p.itemCode, itemName, primaryImage, p.availableQuantity, SUM(us.quantity) AS quantity, priceEach
            FROM  Products p
            JOIN Uniforms u ON p.itemCode = u.itemCode 
            JOIN UniformSizes us ON p.itemCode = us.itemCode 
            WHERE category = '$category'
            GROUP BY p.itemCode
            HAVING availableQuantity = quantity"; // the query will mainly get failed because of this clause.
        $result = run_mysql_query($query);

        if ($result !== false) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            exit("No result returned for the Uniform category");
        }
    }

    return NULL;
}

function get_quantity_in_inventory_by_size(int $item_code, string $size) {
    $query = "SELECT quantity FROM UniformSizes WHERE itemCode = '$item_code' AND size = '$size'";
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        return $result->fetch_array()['quantity'];
    }
    return NULL;
}

function get_quantity_in_inventory(int $item_code) {
    $query = "SELECT availableQuantity FROM Products WHERE itemCode = '$item_code'";
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        return $result->fetch_array()['availableQuantity'];
    }
    return NULL;
}
function get_uploaded_image_link($file_name) {
    return UPLOADED_IMAGE_DIR . $file_name;
}