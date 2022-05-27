<?php
$title = 'Quản Lý Yêu Cầu';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

// Get all status
$query = "SELECT * FROM RequestStatus ORDER BY statusID";
$all_status = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);
$item_count = 0;

for ($i = 0; $i < count($all_status); $i++) {
	$status = $all_status[$i];
	$sequence_number = 1;

	// query the database to get request information
	$query = 
		"SELECT r.requestNumber, r.requestDate, r.classCode, r.studentID,
				(SELECT subjectName FROM Subjects WHERE Subjects.subjectCode = c.subjectCode) AS subjectName,
				CONCAT(IF(s.firstName IS NULL, '', s.firstName), ' ', s.lastName) AS fullName,
				r.startTime, r.endTime, statusName, r.note
		FROM Requests r 
		JOIN RequestStatus os ON r.statusID = os.statusID
		LEFT JOIN Students s ON s.studentID = r.studentID
		LEFT JOIN Classes c ON c.classCode = r.classCode
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
				<tr class="table-column-name">
                    <th class="sequence-number">STT</th>
					<th>Thời gian tạo</th>
                    <th class="col-sm-2">Mã sinh viên</th> 
					<th class="col-sm-2"> Họ Tên</th>
					<th class="col-sm-2">Lớp học phần</th>
                    <th class="col-sm-2">Thời gian mượn</th>
                    <th class="col-sm-2">Thời gian kết thúc</th>
                    <th class="col-sm-2">Trạng thái</th>
					<th class="col-sm-3">Note</th>
					<th class="detail-button col-sm-2" id="detail_button_<?=$status['statusID']?>"></th>
					<th class="update-button col-sm-2" id="update_button_<?=$status['statusID']?>"></th>
				</tr>
			</thead>
			<tbody class="table-body">
				<?php
					foreach($result as $request) {
						$item_count ++;
						$row_colorize = "";
						switch ($request['statusName']) {
							case 'APPROVED': $row_colorize = "table-info"; break;
							case 'SENT': $row_colorize = "table-warning"; break;
						}
						?>
						<tr class="<?=$row_colorize?>" id="request_<?=$request['requestNumber']?>">
							<th><?=($sequence_number++)?></th>
							<td><?=format_datetime_to_display($request['requestDate'])?></td>
							<td><?=$request['studentID']?></td>
							<td><?=$request['fullName']?></td>
							<td><?=($request['classCode'] != "") ? ($request['subjectName']."<br>".$request['classCode']) : "Không"?></td>
							<td><?=format_datetime_to_display($request['startTime'])?></td>
							<td><?=format_datetime_to_display($request['endTime'])?></td>
							<td><?=translated_status($request['statusName'])?></td>
							<td><?=$request['note']?></td>	
							<td>
								<button id="detail_button_<?=$request['requestNumber']?>" class="btn btn-warning" onclick="open_detail(<?=$request['requestNumber']?>)">Chi tiết</button>
							</td>	
							<?php
							if ($request['statusName'] == 'SENT' || $request['statusName'] == 'APPROVED') {
								?>
								<td style="width: 50px">
									<!-- Send requestNumber value to edit.php by GET method. -->
									<a href="edit.php?request=<?=$request['requestNumber']?>">
										<button id="update_button_<?=$request['requestNumber']?>" class="btn btn-warning">Cập nhật</button>
									</a>
								</td>
								<?php
							}
							?>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>

	</div>
</div>
<?php
	// remove update column
	if ($status['statusName'] == 'RETURNED' || $status['statusName'] == 'CANCELED') {
		?>
		<script>
			$("#update_button_<?=$status['statusID']?>").each(function() {
				$(this).remove();
			});
		</script>
		<?php
	}
}
?>
<br>
<?php
if ($item_count == 0) {
	?>
	Không có yêu cầu nào
	<?php
}
include_once("$root_dir/admin/layouts/footer.php");
?>
<script>
function open_detail(request_number) {
	window.location.href = "./detail.php?id=" + request_number;
}
</script>