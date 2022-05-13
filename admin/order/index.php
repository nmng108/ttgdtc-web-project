<?php
	$title = 'Quản Lý Yêu Cầu';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$sql = "select * from orders left join order_details on orders.id = order_details.order_id
    inner join products on products.id = order_details.product_id inner join status on status.status_id = orders.status";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Yêu Cầu Mượn</h3>

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

		// if($item[$index]['id'] != $item[++$index]['id']) {
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
			// } else {
			// 	echo '<tr>
			// 		<th>'.($index).'</th>
            //         <td></td>
            //         <td></td>
            //         <td>'.$item['title'].'</td>
			// 		<td>'.$item['num'].'</td>
            //         <td>'.$item['borrow_time'].'</td>
            //         <td>'.$item['borrow_date'].'</td>
			// 		<td>'.$item['status_name'].'</td>					
			// 	</tr>';
				
			// }
	}
?>
			</tbody>
		</table>
	</div>
 	<a href=""><button>Thay đổi trạng thái</button></a>
</div>



<?php
	require_once('../layouts/footer.php');
?>