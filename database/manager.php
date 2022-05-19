<?php
include_once("$root_dir/includes/utilities.php");

define('HOSTNAME', 'localhost:3306');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'pec_database');
//order
define('ASCENDING', 'ASC');
define('DESCENDING', 'DESC');

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