<?php
session_start();

$root_dir = "../..";

require_once("$root_dir/includes/utilities.php");
require_once("$root_dir/database/manager.php");

if (!isset($_POST['id'])) {
    exit("Delete unsuccessfully.");
}

$query = "DELETE FROM products WHERE itemCode = ".$_POST['id'];


echo run_mysql_query($query) ? "deleted successfully" : "deleted unsuccessfully";
