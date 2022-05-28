<?php
session_start();

$root_dir = "../..";

include_once("$root_dir/database/manager.php");
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/request/manager.php");

if (!isset($_POST)) exit();
$query = "SELECT COUNT(*) total FROM Carts WHERE userID = " . $_SESSION[USERID];
echo run_mysql_query($query)->fetch_array()['total'];