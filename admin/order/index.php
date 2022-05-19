<?php
	$title = 'Quản Lý Đơn Đặt Đồng Phục';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	$sql = "select * from orderdetails left join status_order on status_order.status_id = orderdetails.status";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Đơn mới</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Size M</th>
                    <th>Size L</th>
					<th>Size XL</th>
					<th>Size XXL</th>
					<th>Size XXXL</th>
                    <th>Oversize</th>
                    <th>Trạng thái</th>
                    <th>Tổng đơn</th>
					<th>Note</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		if($item['status'] == 1) {
			echo '<tr>
						<th>'.(++$index).'</th>
						<td>'.$item['full_name'].'</td>
						<td>'.$item['student_ID'].'</td>
						<td>'.$item['quantum_M'].'</td>
                        <td>'.$item['quantum_L'].'</td>
						<td>'.$item['quantum_XL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
                        <td>'.$item['quantum_oversize'].'</td>
						<td>'.$item['status_name'].'</td>
                        <td>'.$item['amount'].' VND</td>
						<td>'.$item['Note'].'</td>
                        <td style="width: 50px">
							<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Cập nhật</button></a>
						</td>
						
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Đơn đang chuẩn bị</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Size M</th>
                    <th>Size L</th>
					<th>Size XL</th>
					<th>Size XXL</th>
					<th>Size XXXL</th>
                    <th>Oversize</th>
                    <th>Trạng thái</th>
                    <th>Tổng đơn</th>
					<th>Note</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		if($item['status'] == 2) {
			echo '<tr>
						<th>'.(++$index).'</th>
						<td>'.$item['full_name'].'</td>
						<td>'.$item['student_ID'].'</td>
						<td>'.$item['quantum_M'].'</td>
                        <td>'.$item['quantum_L'].'</td>
						<td>'.$item['quantum_XL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
                        <td>'.$item['quantum_oversize'].'</td>
						<td>'.$item['status_name'].'</td>
                        <td>'.$item['amount'].' VND</td>
						<td>'.$item['Note'].'</td>
                        <td style="width: 50px">
							<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Cập nhật</button></a>
						</td>
						
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>


<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Đơn đã giao</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
                    <th>Trạng thái</th>
                    <th>Tổng đơn</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		if($item['status'] == 3) {
			echo '<tr>
						<th>'.(++$index).'</th>
						<td>'.$item['full_name'].'</td>
						<td>'.$item['student_ID'].'</td>
						<td>'.$item['status_name'].'</td>
                        <td>'.$item['amount'].' VND</td>

					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>



<?php
	require_once('../layouts/footer.php');
?>