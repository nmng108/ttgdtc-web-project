<?php
$root_dir = "..";

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

if (isset($_POST['item_code']) && isset($_POST['size'])) {
    echo get_quantity_in_inventory_by_size($_POST['item_code'], $_POST['size']);
}