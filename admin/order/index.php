<?php
$title = 'Quản Lý Đơn Đặt Đồng Phục';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");
include_once("$root_dir/order/manager.php");

$query = "SELECT * FROM OrderStatus";
$all_status = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);
$item_count = 0;

for ($i = 0; $i < count($all_status); $i++) {
	$status = $all_status[$i];
	$sequence_number = 1;

	// query the database to get request information
	$sql = 
		"SELECT o.orderNumber, o.orderDate, o.studentID, o.modifiedAt,
				CONCAT(IF(s.firstName IS NULL, '', s.firstName), ' ', s.lastName) AS fullName,
				statusName, o.note 
		FROM Orders o
		JOIN OrderStatus os ON o.statusID = os.statusID
		LEFT JOIN Students s ON s.studentID = o.studentID
		WHERE o.`statusID` = ".$status['statusID']." 
		ORDER BY o.orderDate DESC";
	$result = run_mysql_query($sql)->fetch_all(MYSQLI_ASSOC);

	if (count($result) == 0) continue;
?>
<br>
<br>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<?php
		// determine text inside <h3> tag
		switch($status['statusName']) {
			case "SENT": 
				echo "<h3>Đơn hàng chưa xử lí</h3>"; break;
			case "PREPARING": 
				echo "<h3>Đơn hàng đang thực hiện</h3>"; break;
			case "READY": 
				echo "<h3>Đơn hàng đã sẵn sàng/đang gửi đi</h3>"; break;
			case "RECEIVED": 
				echo "<h3>Đơn hàng đã hoàn thành</h3>"; break;
			case "CANCELED": 
				echo "<h3>Đơn hàng bị huỷ</h3>"; break;
			case "RETURNED": 
				echo "<h3>Đơn hàng hoàn trả</h3>"; break;
		}
		?>

		<table class="table table-bordered table-hover" style="margin-top: 20px; text-align: center;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
                    <th>Thời gian tạo</th>
					<th>Chỉnh sửa gần nhất</th>
					<th>Họ tên sinh viên</th>
                    <th>Mã sinh viên</th>
                    <th>Tổng giá tiền</th>
                    <th>Trạng thái</th>
					<th>Note</th>
					<th>Chi tiết</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$index = 0;
				foreach($result as $order) {
					$item_count ++;
					?>
					<tr>
						<th><?=($sequence_number++)?></th>
						<td><?=format_datetime_to_display($order['orderDate'])?></td>
						<td><?=format_datetime_to_display($order['modifiedAt'])?></td>
						<td><?=$order['fullName']?></td>
						<td><?=$order['studentID']?></td>
						<td><?=get_order_total_price($order['orderNumber'])?></td>
						<!-- status column is no longer nessesary to display -->
						<td><?=$order['statusName']?></td>
						<td><?=$order['note']?></td>	
						<td>
							<button class="btn btn-warning">Chi tiết</button>
						</td>	
						<td style="width: 50px">
							<a href="edit.php?order=<?=$order['orderNumber']?>">
								<button class="btn btn-warning">Cập nhật</button>
							</a>
						</td>
					</tr>;
					<?php
				}
				?>
			</tbody>
		</table>

	</div>
</div>
<?php
}
?>
<br>
<?php
if ($item_count == 0) {
	?>
	Không có đơn nào
	<?php
}
require_once('../layouts/footer.php');
?>