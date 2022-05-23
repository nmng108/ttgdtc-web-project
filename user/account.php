
<?php 

$title = 'Tài khoản người dùng';
include('layouts/layout.php');
include_once('layouts/header.php');
$user_id = $user['id'];
$sql = "select * from orders left join order_details on orders.id = order_details.order_id
    inner join products on products.id = order_details.product_id inner join status on status.status_id = orders.status
	where orders.user_id = $user_id";
$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px; margin-bottom: 70px;">
	<div class="col-md-12 table-responsive">
	<h1 style="font-size: 20px;">Thông tin người mượn</h1>
		<table class="table table-bordered table-hover"  style="margin-top: 20px; width: 900px; margin-left: 20px;">
			<thead class="table-success">
				<tr>
					<th>Họ Tên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Trường</th>
					<th>Mã sinh viên</th>
				</tr>
			</thead>
			<tbody>
<?php
		echo '<tr>
					<td>'.$user['f_name'].'</td>
					<td>'.$user['email'].'</td>
					<td>'.$user['phone_number'].'</td>
					<td>'.$user['address_'].'</td>
					<td>'.$user['student_ID'].'</td>
					</tr>';		
?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12 table-responsive">
		<h1 style="font-size: 20px;">Chi tiết lịch sử mượn dụng cụ</h1>
		<table class="table table-bordered table-hover" style="margin-top: 20px; margin-left: 20px;">
			<thead class="table-success">
				<tr>
					<th>Số thứ tự</th>
					<th>Tên dụng cụ</th>
					<th>Hình ảnh</th>
					<th>Số lượng</th>
					<th>Thời gian</th>
					<th>Ngày</th>
					<th>Trạng thái</th>
					<th>Ghi chú</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
                    <td>'.$item['title'].'</td>
					<td><img src="'.$item['thumbnail'].'" style="width: 100px"></td>
                    <td>'.$item['num'].'</td>
                    <td>'.$item['borrow_time'].'</td>
                    <td>'.$item['borrow_date'].'</td>
					<td>'.$item['status_name'].'</td>	
					<td></td>
				
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
	

</div>

<?php
include_once('layouts/footer.php');
?>