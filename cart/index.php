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
<div class="row">
	<div class="container">
		<table class="table table-hover" style="width: 800px; margin-left:90px;">
			<thead class="table-success">
				<tr>
					<th class="sequence-number" style="text-align:center;">STT</th>
					<th class="item-image" style="text-align:center;">Hình ảnh</th>
					<th class="item-name" style="text-align:center;">Tên dụng cụ</th>
					<th class="item-quantity" style="text-align:center;">Số lượng</th>
					<th class="delete-button"></th>
					<th class="edit-button"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$cart = get_cart_info($_SESSION[USERID]);

				for ($i = 0; $i < $cart->num_rows; $i++) { 
					$item = $cart->fetch_array();
					?>
					<tr id="item_<?=$i + 1?>">
						<td class="sequence-number" style="text-align:center;"><?=$i + 1?></td>
						<td class="item-image" style="text-align:center;"><img src="<?=$item['primaryImage']?>" style="width: 100px"></td>
						<td class="item-name" style="text-align:center;"><?=$item['itemName']?></td>
						<td class="item-quantity" style="text-align:center;">
							<input type="number" name="quantity" id="quantity_input_<?=$i + 1?>" value="<?=$item['quantity']?>" disabled>
						</td>
						<td class="delete-button">
							<button id="delete_button_<?=$i + 1?>" onclick="delete_item(this)" hidden>Xóa</button>
						</td>
						<td class="edit-button">
							<button id="edit_button_<?=$i + 1?>" onclick="enable_edit_mode(this)">Sửa</button>
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
<!-- body END -->
<script type="text/javascript">
	function deleteItem(id) {
		$.post('api/api-product.php', {
			'action': 'delete',
			'id': id
		}, function(data) {
			location.reload()
		})
	}

	function enable_edit_mode(element) {
		let splited_id =  element.id.split('_');
		const sequence_number = splited_id[2];
		const delete_button = document.getElementById('delete_button_' + sequence_number);
		const quantity_input = document.getElementById('quantity_input_' + sequence_number);
		
		if (splited_id[0] == "edit"){
			element.innerHTML = 'Xong';
			element.id = "confirm_button_" + sequence_number;
			delete_button.hidden = false;
			quantity_input.disabled = false;
		} else if (splited_id[0] == "confirm") {
			element.innerHTML = 'Sửa';
			element.id = "edit_button_" + sequence_number;
			delete_button.hidden = true;
			quantity_input.disabled = true;
		}
	}
	
	var delete_item = function(element) {
		element.parentElement.parentElement.hidden = true;
	}
</script>
<?php
require_once("$root_dir/user/layouts/footer.php");
?>
