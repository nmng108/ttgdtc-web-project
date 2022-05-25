<?php 
session_start();

$title = 'Giỏ đồ';
$root_dir = "..";

include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/user_layouts/layout.php");


include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

$category_count = 0;
?>

<!-- body START -->
<br>
<br>
<?php
//Displaying Sport Equipments items in cart
$cart = get_cart_info_by_category($_SESSION[USERID], SPORT_EQUIPMENT)->fetch_all(MYSQLI_ASSOC);
if (count($cart) > 0) {
	$category_count += 1;
	include_once("$root_dir/cart/sport_equipment_box_cart.php");
}

//Displaying Uniform items in cart
$cart = get_cart_info_by_category($_SESSION[USERID], UNIFORM)->fetch_all(MYSQLI_ASSOC);
if (count($cart) > 0) {
	$category_count += 1;
	include_once("$root_dir/cart/uniform_box_cart.php");
}

if ($category_count == 0) {
	//only appears after loading/reloading page.
	?>
	<p style="font-size: 22px; color: darkslategray">Không có vật phẩm nào trong giỏ hàng</p>
	<?php
}
?>
<br>
<hr>

<script src="<?=$root_dir?>/cart/data handler.js"></script>

<!-- body END -->

<?php
include_once("$root_dir/user/layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>
