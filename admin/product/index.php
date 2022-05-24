<?php
$title = 'Quản Lý Dụng Cụ';
$root_dir = '../..';

require_once("$root_dir/admin/layouts/header.php");

$query = "SELECT * FROM Products WHERE category = '".SPORT_EQUIPMENT."'";
$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Dụng Cụ Trong Kho</h3>
		<button class="btn btn-primary" onclick="window.location.href='./upload.php'">Thêm mới</button>

		<table class="table table-bordered table-hover" style="margin-top: 20px; text-align: center;">
			<thead class="table-success">
				<tr>
                    <th>STT</th>
					<th>Tên</th>
					<th>Hình ảnh</th>
					<th>Số lượng còn lại trong kho</th>
					<th>Mô tả</th>
					<th>Ngày thêm</th>
					<th>Lần chỉnh sửa gần nhất</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($result as $item) {
		?>
		<tr>
			<th><?=(++$index)?></th>
			<td><?=$item['itemName']?></td>
			<td><img src="<?=get_uploaded_image_link($item['primaryImage'])?>" style="width: 100px"></td>					
			<td><?=$item['availableQuantity']?></td>	
			<td><?=$item['description']?></td>	
			<td><?=format_datetime_to_display($item['createdAt'])?></td>	
			<td><?=format_datetime_to_display($item['modifiedAt'])?></td>	
			<td>
				<!-- <button type="button" class="btn btn-primary" style="overflow: hidden; margin-right: 1em;">Sửa</button> -->
				<button type="button" class="btn btn-primary" style="overflow: hidden;">Sửa</button>
				<div style="float: right; overflow: hidden; height: 1px;">
				</div>
				<hr>
				<button type="button" class="btn btn-warning" style="overflow: hidden;">Xóa</button>
				<!-- <button type="button" class="btn btn-warning" style="overflow: hidden; margin-left: 1em;">Xóa</button> -->
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
	require_once('../layouts/footer.php');
?>