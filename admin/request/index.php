<?php
$title = 'Quản Lý Yêu Cầu';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

// Get all status
$query = "SELECT * FROM RequestStatus";
$all_status = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

for ($i = 0; $i < count($all_status); $i++) {
	$status = $all_status[$i];
	$sequence_number = 1;

	// query the database to get request information
	$query = 
		"SELECT r.requestNumber, r.requestDate, r.classCode, r.studentID, 
				CONCAT(IF(s.firstName IS NULL, '', s.firstName), ' ', s.lastName) AS fullName,
				r.startTime, r.endTime, statusName AS `status`, r.note
		FROM Requests r 
		JOIN RequestStatus os ON r.statusID = os.statusID
		LEFT JOIN Students s ON s.studentID = r.studentID
		WHERE r.statusID = ".$status['statusID']."
		ORDER BY r.requestDate DESC";
	$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

	if (count($result) == 0) continue;
	// if there's at least 1 row in the result then print appropriate table.
?>
<br>
<br>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<?php
		// determine text inside <h3> tag
		switch($status['statusName']) {
			case "SENT": 
				echo "<h3>Yêu cầu chưa xử lí</h3>"; break;
			case "APPROVED": 
				echo "<h3>Yêu cầu đang thực hiện</h3>"; break;
			case "CANCELED": 
				echo "<h3>Yêu cầu bị huỷ</h3>"; break;
			case "RETURNED": 
				echo "<h3>Yêu cầu đã hoàn thành</h3>"; break;
		}
		?>

		<table class="table table-bordered table-hover" style="margin-top: 20px; text-align: center;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th>Thời gian tạo</th>
                    <th>Mã sinh viên</th> 
					<th> Họ Tên</th>
					<th>Lớp học phần</th>
                    <th>Thời gian mượn</th>
                    <th>Thời gian kết thúc</th>
                    <th>Trạng thái</th>
					<th>Note</th>
					<th>Chi tiết</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
				<?php
					foreach($result as $request) {
						?>
						<tr>
							<th><?=($sequence_number++)?></th>
							<td><?=format_datetime_to_display($request['requestDate'])?></td>
							<td><?=$request['studentID']?></td>
							<td><?=$request['fullName']?></td>
							<td><?=($request['classCode'] != "") ? $request['classCode'] : "Không"?></td>
							<td><?=format_datetime_to_display($request['startTime'])?></td>
							<td><?=$request['endTime']?></td>
							<td><?=$request['status']?></td>
							<td><?=$request['note']?></td>	
							<td>
								<button class="btn btn-warning">Chi tiết</button>
							</td>	
							<td style="width: 50px">
								<!-- Send requestNumber value to edit.php by GET method. -->
								<a href="edit.php?request=<?=$request['requestNumber']?>">
									<button class="btn btn-warning">Cập nhật</button>
								</a>
							</td>
						</tr>
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
	require_once("$root_dir/admin/layouts/footer.php");
?>