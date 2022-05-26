<?php
$title = 'Quản Lý Người Dùng';
$root_dir = '../..';

require_once("$root_dir/admin/layouts/header.php");

$query = 
	"SELECT s.studentID, username, email, phoneNumber, school, createdAt, modifiedAt, 
	IFNULL(`as`.classCode, 'Không tham gia') AS classCode, 
	CONCAT(IF(firstName IS NULL, '', firstName), ' ', lastName) AS fullName, 'Student' AS `role`
	FROM Students s LEFT JOIN `AttendingStudents` `as` ON s.studentID = `as`.studentID
	UNION
	SELECT adminID, username, email, phoneNumber, '' AS school, createdAt, modifiedAt, 
	'' AS classCode, 
	CONCAT(IF(firstName IS NULL, '', firstName), ' ', lastName) AS fullName, 'Admin' AS `role`
	FROM Admins";
$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);
?>
<!-- Thông tin của tất cả người dùng -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Người Dùng</h3>
		<a href="edit.php"><button class="btn btn-success">Thêm Tài Khoản</button></a>
		<table class="table table-bordered table-hover" style="margin-top: 20px; text-align: center;">
			<thead class="table-success">
				<tr>
					<th>STT</th>
					<th>MSV</th>
					<th>Họ & Tên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Trường</th>
					<th>Lớp học phần</th>
					<th>Tên đăng nhập</th>
					<th>Vai trò</th>
					<th>Ngày thêm</th>
					<th>Chỉnh sửa gần nhất</th>
					<th style="width: 50px"></th>
					<th style="width: 50px"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$index = 0;
					foreach($result as $user) {
						?>
						<tr>
							<th><?=(++$index)?></th>
							<td><?=$user['studentID']?></td>
							<td><?=$user['fullName']?></td>
							<td><?=$user['email']?></td>
							<td><?=$user['phoneNumber']?></td>
							<td><?=$user['school']?></td>
							<td><?=$user['classCode']?></td>
							<td><?=$user['username']?></td>
							<td><?=$user['role']?></td>
							<td><?=format_datetime_to_display($user['createdAt'])?></td>
							<td><?=format_datetime_to_display($user['modifiedAt'])?></td>
							<?php
							if ($user['role'] == 'Admin') continue;
							?>
							<td style="width: 50px">
								<a href="edit.php?id=<?=$user['studentID']?>">
									<button class="btn btn-warning">Sửa</button>
								</a>
							</td>
							<td style="width: 50px">
								<?php
									?>
									<button onclick="deleteUser(<?=$user['studentID']?>)" class="btn btn-danger">Xoá</button>
									<?php
								// }
								?>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function deleteUser(id) {
		option = confirm('Bạn có chắc chắn muốn xoá tài khoản này không?')
		if(!option) return;
		$.post('delete_user.php', { 
			'id': id,
		}, function(data) { //data we got includes all js scripts(may be all text outside php scripts) intergrated in dest file besides information from echo statements.
			console.log(data);
			// location.reload();
		})
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>