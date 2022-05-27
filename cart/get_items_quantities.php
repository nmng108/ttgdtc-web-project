<?php
session_start();

$root_dir = "..";

include_once($root_dir."/cart/manager.php");
include_once($root_dir."/includes/utilities.php");

if (isset($_SESSION[USERID]) && isset($_POST['category'])) {
    $query = "SELECT * FROM Carts WHERE userID = ".$_SESSION[USERID]." AND category = ".$_POST['category'];
    $result = run_mysql_query($query);
    
}