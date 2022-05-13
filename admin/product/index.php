<?php
	$title = 'Quản Lý Dụng Cụ';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	$sql = "select * from products";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Số Lượng Dụng Cụ Trong Kho</h3>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th>Tên</th>
					<th>Hình ảnh</th>
					<th>Số lượng còn lại trong kho</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td>'.$item['title'].'</td>
					<td><img src="../'.$item['thumbnail'].'" style="width: 100px"></td>					
					<td>'.$item['quantityInStock'].'</td>	
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
	
</div>


<?php
	require_once('../layouts/footer.php');
?>