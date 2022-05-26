<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");
?>

<div id="category_<?=SPORT_EQUIPMENT?>" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Yêu cầu mượn</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-success">
							<tr>
								<th class="col-sm-1 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-name">Tên dụng cụ</th>
								<th class="col-sm-2 available-quantity">Kho</th>
								<th class="col-sm-2 item-quantity" style="width:15%;">Số lượng</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($cart); $i++) { 
								$item = $cart[$i];
								$class_value = "";
								if ($item['quantity'] > $item['availableQuantity']) {
									$class_value = "table-danger";
								}
								?>
								<tr class="<?=$class_value?>" id="row_item_<?=$item['itemCode']?>">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><img src="<?=get_uploaded_image_link($item['primaryImage'])?>" style="width: 100%"></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
																	
									<td class="available-quantity"><?=$item['availableQuantity']?></td>

									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height: 35px;" disabled>
										<br>
										<span id="quantity_warning_<?=$item['itemCode']?>">
											<?php
											if ($item['quantity'] > $item['availableQuantity']) {
												echo "Số lượng lớn hơn trong kho";
											} else {}
											?>
										</span>
									</td>
									
									<td class="delete-button">
										<button class="btn btn-danger" id="delete_button_<?=$item['itemCode']?>" onclick="delete_item(this)" hidden>Xóa</button>
									</td>
									
									<td class="edit-button">
										<button class="btn btn-warning" id="edit_button_<?=$item['itemCode']?>" onclick="switch_edit_mode(this)">Sửa</button>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<p id="notif_<?=SPORT_EQUIPMENT?>" style="font-size: 26px; color: red">
					
					</p>
					<a href="./checkout.php?cat=<?=SPORT_EQUIPMENT?>" class="checkout-button">
						<button class="" id="checkout_button_<?=SPORT_EQUIPMENT?>"  onclick="return process_cart(this, <?=$_SESSION[USERID]?>)">Tiếp tục</button>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>

<br>
<hr>
<br>
