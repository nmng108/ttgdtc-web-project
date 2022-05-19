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
//Order: Sport equipment -> Uniform
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
								<th class="col-sm-2 item-quantity" style="width:15%;">Số lượng</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cart = get_cart_info_by_category($_SESSION[USERID], SPORT_EQUIPMENT)->fetch_all(MYSQLI_ASSOC);

							for ($i = 0; $i < count($cart); $i++) { 
								$item = $cart[$i];
								?>
								<tr id="item_<?=$item['itemCode']?>">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><img src="<?=$item['primaryImage']?>" style="width: 30px"></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
									
									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height:35px;" disabled>
										<br>
										<span>Invalid quantity</span>
									</td>
									
									<td class="delete-button">
										<button id="delete_button_<?=$item['itemCode']?>" onclick="delete_item(this)" hidden>Xóa</button>
									</td>
									
									<td class="edit-button">
										<button id="edit_button_<?=$item['itemCode']?>" onclick="enable_edit_mode(this)">Sửa</button>
									</td>
								</tr>
								<?php
							}
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

<br>
<hr>
<br>

<div class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Đặt mua đồng phục</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-1 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-name">Tên</th>
								<th class="col-sm-2 item-quantity" style="width:15%;">Số lượng</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cart = get_cart_info_by_category($_SESSION[USERID], UNIFORM)->fetch_all(MYSQLI_ASSOC);
							
							// use $item['itemCode'] to generate the id value of some tags.
							for ($i = 0; $i < count($cart); $i++) { 
								$item = $cart[$i];
								?>
								<tr id="item_<?=$item['itemCode']?>" style="text-align:center;">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><img src="<?=$item['primaryImage']?>" style="width: 30px"></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
									
									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" disabled>
									</td>
									
									<td class="delete-button">
										<button id="delete_button_<?=$item['itemCode']?>" onclick="delete_item(this)" hidden>Xóa</button>
									</td>
									
									<td class="edit-button">
										<button id="edit_button_<?=$item['itemCode']?>" onclick="enable_edit_mode(this)">Sửa</button>
									</td>
								</tr>
								<?php

							}
							?>
						</tbody>
					</table>
					<p style="font-size: 26px; color: red">
					</p>
					<a href="checkout.php">
						<button class="" >Tiếp tục</button>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>
<br>
<script src="<?=$root_dir?>/cart/data handler.js"></script>

<!-- body END -->

<?php
require_once("$root_dir/user/layouts/footer.php");
?>
