<?php
	$title = 'Quản Lý Yêu Cầu';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	$sql = "select * from requests left join requestdetails on requests.id = requestdetails.order_id
    inner join products on products.id = requestdetails.product_id inner join status on status.status_id = requests.status";
	$data = executeResult($sql);
?>
<!-- quản lí các yêu cầu chưa xử lí -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Yêu cầu chưa xử lí</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Tên Dụng Cụ</th>
					<th>Số lượng</th>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
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
						<td>'.$item['title'].'</td>
						<td>'.$item['num'].'</td>
						<td>'.$item['borrow_time'].'</td>
						<td>'.$item['borrow_date'].'</td>
						<td>'.$item['status_name'].'</td>
						<td>'.$item['Note'].'</td>	
						<td style="width: 50px">
							<a href="editor.php?id='.$item['order_id'].'"><button class="btn btn-warning">Cập nhật</button></a>
						</td>
						
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>

<!-- Các yêu cầu đang trong quá trình thực hiện -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Yêu cầu đang thực hiện</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Tên Dụng Cụ</th>
					<th>Số lượng</th>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
					<th>Note</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		if($item['status'] == 4) {
			echo '<tr>
						<th>'.(++$index).'</th>
						<td>'.$item['full_name'].'</td>
						<td>'.$item['student_ID'].'</td>
						<td>'.$item['title'].'</td>
						<td>'.$item['num'].'</td>
						<td>'.$item['borrow_time'].'</td>
						<td>'.$item['borrow_date'].'</td>
						<td>'.$item['status_name'].'</td>
						<td>'.$item['Note'].'</td>	
						<td style="width: 50px">
							<a href="editor.php?id='.$item['order_id'].'"><button class="btn btn-warning">Cập nhật</button></a>
						</td>
						
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>

<!-- quản lí các yêu cầu đã bị huỷ -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Yêu cầu bị huỷ</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Tên Dụng Cụ</th>
					<th>Số lượng</th>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
					<th>Note</th>
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
						<td>'.$item['title'].'</td>
						<td>'.$item['num'].'</td>
						<td>'.$item['borrow_time'].'</td>
						<td>'.$item['borrow_date'].'</td>
						<td>'.$item['status_name'].'</td>
						<td>'.$item['Note'].'</td>
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>

<!-- Các yêu cầu đã hoàn thành -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Yêu cầu đã hoàn thành</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th> Họ Tên</th>
                    <th>Mã sinh viên</th>
					<th>Tên Dụng Cụ</th>
					<th>Số lượng</th>
                    <th>Thời gian</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
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
						<td>'.$item['title'].'</td>
						<td>'.$item['num'].'</td>
						<td>'.$item['borrow_time'].'</td>
						<td>'.$item['borrow_date'].'</td>
						<td>'.$item['status_name'].'</td>
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