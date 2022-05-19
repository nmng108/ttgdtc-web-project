<?php
	$title = 'Quản Lý Người Dùng';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	$sql = "select Users.*, Role.name as role_name from Users left join Role on Users.role_id = Role.id where Users.deleted = 0";
	$data = executeResult($sql);
?>
<!-- Thông tin của tất cả người dùng -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Người Dùng</h3>
		<a href="editor.php"><button class="btn btn-success">Thêm Tài Khoản</button></a>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
					<th>STT</th>
					<th>Họ & Tên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Trường</th>
					<th>Mã sinh viên</th>
					<th>Quyền</th>
					<th style="width: 50px"></th>
					<th style="width: 50px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td>'.$item['f_name'].'</td>
					<td>'.$item['email'].'</td>
					<td>'.$item['phone_number'].'</td>
					<td>'.$item['address_'].'</td>
					<td>'.$item['student_ID'].'</td>
					<td>'.$item['role_name'].'</td>
					<td style="width: 50px">
						<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>
					</td>
					<td style="width: 50px">';
		if($admin['id'] != $item['id'] && $item['role_id'] != 1) {
			echo '<button onclick="deleteUser('.$item['id'].')" class="btn btn-danger">Xoá</button>';
		}
		echo '
					</td>
				</tr>';
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
		$.post('form_api.php', {
			'id': id,
			'action': 'delete'
		}, function(data) {
			location.reload()
		})
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>