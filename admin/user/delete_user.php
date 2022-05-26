<?php
$root_dir = "../..";

require_once("$root_dir/includes/utilities.php");
require_once("$root_dir/database/manager.php");

if (!isset($_POST['id'])) {
    exit("delete unsuccessfully. Cannot get user id.");
}

$query = "DELETE FROM Students WHERE studentID = ".$_POST['id'];

echo run_mysql_query($query) ? "deleted successfully" : "deleted unsuccessfully";
