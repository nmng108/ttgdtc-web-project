<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");
?>

<div id="category_<?=UNIFORM?>" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Đặt mua đồng phục</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-success">
							<tr>
								<th class="col-sm-2 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-name">Tên</th>
								<th class="col-sm-2 item-size">Kích cỡ</th>
								<th class="col-sm-2 available-quantity">Trong kho</th>
								<th class="col-sm-2 item-quantity">Số lượng</th>
								<th class="col-sm-2 item-price-each">Giá</th>
								<th class="col-sm-2 delete-button"></th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							// use $item['itemCode'] to generate the id value of some tags.
							for ($i = 0; $i < count($cart); $i++) { 
								$item = $cart[$i];
								$class_value = "";
								if ($item['quantity'] > $item['availableQuantity']) {
									$class_value = "table-warning";
								}
								?>
								<tr class="<?=$class_value?>" id="item_<?=$item['itemCode']?>" style="text-align:center;">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><img src="<?=$item['primaryImage']?>" style="width: 30px"></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
																	
									<td class="item-size"><?=$item['size']?></td>
																	
									<td class="available-quantity"><?=$item['availableQuantity']?></td>

									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height: 35px;" disabled>
										<br>
										<span id="quantity_warning_<?=$item['itemCode']?>">
											<?php
											if ($item['quantity'] > $item['availableQuantity']) {
												echo "Số lượng lớn hơn trong kho";
											} else {
											}
											?>
										</span>
									</td>
									
									<td class="item-price-each"><?=$item['priceEach']?></td>

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
					<p id="notif_<?=UNIFORM?>" style="font-size: 26px; color: red">
					
					</p>
					<a href="./checkout.php?cat=<?=UNIFORM?>" class="checkout-button">
						<button  id="checkout_button_<?=UNIFORM?>"  onclick="return process_cart(this)">Tiếp tục</button>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>
