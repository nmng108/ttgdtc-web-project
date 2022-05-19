<?php 
session_start();

$title = 'Giỏ đồ';
$root_dir = "..";
include_once("$root_dir/includes/user_layouts/layout.php");
include_once("$root_dir/includes/user_layouts/header.php");

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");
?>

<!-- body START -->
<br>
<br>
<?php
//Displaying order: Sport equipment -> Uniform
$cart = get_cart_info($_SESSION[USERID])->fetch_all(MYSQLI_ASSOC);
$is_opening_new_card = false;

for ($i = 0; $i < count($cart); $i++) { 
	$item = $cart[$i];
	if ($item['category'] == "SPORT EQUIPMENT" && $is_opening_new_card === false) {
		$is_opening_new_card = true;
?>

<div class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Yêu cầu mượn</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-1 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-name">Tên dụng cụ</th>
								<th class="col-sm-2 available-quantity">Số lượng còn lại</th>
								<th class="col-sm-2 item-quantity" style="width:15%;">Số lượng</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
	}
	if ($item['category'] == "UNIFORM" && $is_opening_new_card === true) {
		$is_opening_new_card = false;
		?>

<br>
<hr>
<br>

<div class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Mua đồng phục</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr style="text-align:center;">
								<th class="col-sm-2 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-name">Tên</th>
								<th class="col-sm-2 item-quantity">Số lượng</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
		<?php
	}
							?>
							<!-- Common code for both tables. -->
							<tr id="item_<?=$item['itemCode']?>">
								<td class="sequence-number"><?=$i + 1?></td>
								
								<td class="item-image"><img src="<?=$item['primaryImage']?>" style="width: 30px"></td>
								
								<td class="item-name"><?=$item['itemName']?></td>
								
								<td class="available-quantity"><?=$item['availableQuantity']?></td>
								
								<td class="item-quantity">
									<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height:35px;" disabled>
									<br>
									<span id="quantity_warning_<?=$item['itemCode']?>"></span>
								</td>
								
								<td class="delete-button">
									<button id="delete_button_<?=$item['itemCode']?>" onclick="delete_item(this)" hidden>Xóa</button>
								</td>
								
								<td class="edit-button">
									<button id="edit_button_<?=$item['itemCode']?>" onclick="switch_edit_mode(this)">Sửa</button>
								</td>
							</tr>
							<?php

	if ((isset($cart[$i+1]) && $cart[$i]['category'] !== $cart[$i+1]['category'])
			|| $i === (count($cart) - 1)) {
		?>
						</tbody>
					</table>
					<p style="font-size: 26px; color: red">
					</p>
					<a href="checkout.php" style="align-content: right">
						<button class="" >Tiếp tục</button>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
	}
}
?>
<br>
<script src="<?=$root_dir?>/cart/data handler.js"></script>

<!-- body END -->

<?php
require_once("$root_dir/includes/user_layouts/footer.php");
?>
