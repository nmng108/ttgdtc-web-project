<?php
session_start();

$root_dir = "..";
$title = 'Trang chủ';

include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");

?>
<br>
<br>
<br>

<?php
include_once("$root_dir/request/requests_table.php");
?>
<br>
<br>

<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>
