<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

$query = "SELECT count(*) `total` FROM `Carts` WHERE `userID` = ".$_SESSION[USERID];
$result = run_mysql_query($query);
$count = 0;

if ($result !== false) {
    $count = $result->fetch_array()['total'];
} 
?>
<span class="cart_icon">
	<span class="cart_count"><?=$count?></span>
	<a href="<?=$root_dir?>/cart"><img src="https://gokisoft.com/img/cart.png"></a>
</span>
