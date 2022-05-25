<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");
include_once("$root_dir/request/manager.php");

$result = get_all_requests($_SESSION[USERID]);
?>

<div id="request_container" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Yêu cầu mượn dụng cụ</b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container table-responsive-lg" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-2 sequence-number">STT</th>
								<th class="col-sm-2 request-date">Thời gian gửi</th>
								<th class="col-sm-2 modified-date">Chỉnh sửa gần nhất</th>
								<th class="col-sm-2 start-date">Thời gian bắt đầu</th>
								<th class="col-sm-2 end-date">Thời gian kết thúc</th>
								<th class="col-sm-3 note">Ghi chú</th>
								<th class="col-sm-2 request-status">Trạng thái</th>
								<th class="col-sm-2 detail-button"></th>
								<th class="col-sm-2 cancel-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($result); $i++) { 
								$item = $result[$i];
								?>
								<tr class="item-info" id="item_<?=$item['requestNumber']?>" style="text-align: center;">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="request-date"><?=$item['requestDate']?></td>
									
									<td class="modified-date"><?=$item['modifiedAt']?></td>
																	
									<td class="start-date"><?=$item['startTime']?></td>
																	
									<td class="end-date"><?=$item['endTime']?></td>

									<td class="note"><?=$item['note']?></td>
									
									<td class="request-status"><?=$item['statusName']?></td>
									
									<td class="cancel-button">
										<button class="btn" id="detail_button_<?=$item['requestNumber']?>" onclick="return false">Chi tiết</button>
									</td>

									<td class="cancel-button">
										<button class="btn" id="cancel_button_<?=$item['requestNumber']?>" onclick="return false">Hủy</button>
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