<?php 
$title = 'Tài khoản người dùng';
include_once('layouts/header.php');
//id của người dùng đang đăng nhập
$user_id = $user['id'];
//truy vấn dữ liệu các yêu cầu mượn dụng cụ
$sql = "select * from requests left join requestdetails on requests.id = requestdetails.order_id
    inner join products on products.id = requestdetails.product_id inner join status on status.status_id = requests.status
	where requests.user_id = $user_id";
$data = executeResult($sql);
//truy vấn dữ liệu đơn đặt đồng phục
$sql1 = "select * from orderdetails left join status_order on status_order.status_id = orderdetails.status where orderdetails.user_id = $user_id";
$data1 = executeResult($sql1);
?>
<!-- Hiển thị thông tin các yêu cầu mượn -->
<div class="row" style="margin-top: 20px; margin-bottom: 70px;">
	<div class="infor">
	<h1 class = "title_account">Thông tin sinh viên</h1>
		<div class="panel-body"  >
			Họ tên: <?=$user['f_name']?><br>
			Mã sinh viên: <?=$user['student_ID']?><br>
			Số điện thoại: <?=$user['phone_number']?><br>
			Trường: <?=$user['address_']?><br>
		</div>
	</div>
	<div class="col-md-12 table-responsive">
		<h1 style="font-size: 20px;">Chi tiết lịch sử mượn dụng cụ</h1>
		<table class="table table-bordered table-hover" style="margin-top: 20px; margin-left: 20px;">
			<thead class="table-success">
				<tr>
					<th>STT</th>
					<th>Tên dụng cụ</th>
					<th>Hình ảnh</th>
					<th>Số lượng</th>
					<th>Thời gian</th>
					<th>Ngày</th>
					<th>Trạng thái</th>
					<th>Lớp</th>
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
					<td>'.$item['class'].'</td>	
					<td>'.$item['Note'].'</td>	
		
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
</div>

<!-- Hiển thị thông tin các đơn đặt đồng phục -->
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h5 style="color:red;">Thông tin đặt đồng phục</h5>
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th>Size M</th>
                    <th>Size L</th>
					<th>Size XL</th>
					<th>Size XXL</th>
					<th>Size XXXL</th>
                    <th>Oversize</th>
                    <th>Trạng thái</th>
                    <th>Tổng đơn</th>
					<th>Ghi chú</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data1 as $item) {
		if($item['status'] == 1) {
			echo '<tr>
						<th>'.(++$index).'</th>
						<td>'.$item['quantum_M'].'</td>
                        <td>'.$item['quantum_L'].'</td>
						<td>'.$item['quantum_XL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
						<td>'.$item['quantum_XXL'].'</td>
                        <td>'.$item['quantum_oversize'].'</td>
						<td>'.$item['status_name'].'</td>
                        <td>'.$item['amount'].' VND</td>
						<td>'.$item['Note'].'</td>	
					</tr>';
		}
	}
?>
			</tbody>
		</table>
	</div>
</div>

<?php
include_once('layouts/footer.php');
?>