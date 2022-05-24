<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");
include_once("$root_dir/order/manager.php");

$result = get_all_orders($_SESSION[USERID]);
?>

<div id="order_container" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Đơn đặt đồng phục</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container table-responsive-lg" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-2 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Thời gian gửi</th>
								<th class="col-sm-2 item-name">Chỉnh sửa gần nhất</th>
								<th class="col-sm-2 total-price">Tổng giá tiền</th>
								<th class="col-sm-2 payment-method">Phương thức thanh toán</th>
								<th class="col-sm-2 note">Ghi chú</th>
								<th class="col-sm-2 item-status">Trạng thái</th>
								<th class="col-sm-2 detail-button"></th>
								<th class="col-sm-2 cancel-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($result); $i++) { 
								$item = $result[$i];
								?>
								<tr class="item-info" id="item_<?=$item['orderNumber']?>" style="text-align: center;">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><?=$item['orderDate']?></td>
									
									<td class="item-name"><?=$item['modifiedAt']?></td>
																	
									<td class="total-price"><?=get_order_total_price($item['orderNumber'])?></td>
																	
									<td class="payment-method"><?=$item['endTime']?></td>

									<td class="note"><?=$item['note']?></td>
									
									<td class="item-status"><?=$item['statusName']?></td>
									
									<td class="cancel-button">
										<button class="btn" id="detail_button_<?=$item['orderNumber']?>" onclick="return false">Chi tiết</button>
									</td>

									<td class="cancel-button">
										<button class="btn" id="cancel_button_<?=$item['orderNumber']?>" onclick="return false">Hủy</button>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
