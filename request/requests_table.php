<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

$result = get_data_from_all_columns("Requests", "studentID = ".$_SESSION[USERID], 'status')->fetch_all(MYSQLI_ASSOC);
?>

<div id="request_container" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Yêu cầu mượn dụng cụ</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-2 sequence-number">STT</th>
								<th class="col-sm-2 item-image">Thời gian gửi</th>
								<th class="col-sm-2 item-name">Chỉnh sửa gần nhất</th>
								<th class="col-sm-2 item-size">Thời gian bắt đầu</th>
								<th class="col-sm-2 available-quantity">Thời gian kết thúc</th>
								<th class="col-sm-2 item-quantity">Ghi chú</th>
								<th class="col-sm-2 item-price-each">Trạng thái</th>
								<th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($result); $i++) { 
								$item = $result[$i];
								?>
								<tr class="" id="item_<?=$item['itemCode']?>" style="text-align:center;">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-image"><?=$item['requestDate']?></td>
									
									<td class="item-name"><?=$item['modifiedAt']?></td>
																	
									<td class="item-size"><?=$item['startTime']?></td>
																	
									<td class="available-quantity"><?=$item['endTime']?></td>

									<td class="item-quantity"><?=$item['note']?></td>
									
									<td class="item-price-each"><?=$item['status']?></td>
									
									<!-- <td class="edit-button">
										<button id="edit_button_<?=$item['itemCode']?>" onclick="switch_edit_mode(this)">Sửa</button>
									</td> -->
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
