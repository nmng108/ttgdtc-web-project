<?php
$title = 'Quản Lý Dụng Cụ';
$root_dir = '../..';

require_once("$root_dir/admin/layouts/header.php");

$query = "SELECT * FROM Products WHERE category = '".SPORT_EQUIPMENT."'";
$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);
?>

<!-- <div class="row" style="margin-top: 20px;"> -->
	<div class="col-md-12 table-responsive" style="margin-top: 20px;">
		<h3>Quản Lý Dụng Cụ Trong Kho</h3>
		<table class="table table-bordered table-hover" style="margin-top: 20px; text-align: center;">
			<thead class="table-success">
				<tr>
                    <th class=" ">STT</th>
					<th class="col-sm-2 ">Tên</th>
					<th class="col-sm-3 ">Hình ảnh</th>
					<th class="col-sm-1 ">Số lượng còn lại trong kho</th>
					<th class="col-sm-3 ">Mô tả</th>
					<th class="col-sm-2 ">Ngày thêm</th>
					<th class="col-sm-2 ">Lần chỉnh sửa gần nhất</th>
					<th class="col-sm-2 "></th>
				</tr>
			</thead>
			<tbody class="table-body">
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
	<br>
	<!-- window.location.href='./upload.php' -->
	<button class="btn btn-primary" onclick="upload_product(this)">
		Thêm mới
	</button>

<!-- </div> -->


<?php
	require_once('../layouts/footer.php');
?>

<script>
var itemTotal = <?=count($result)?>;

function upload_product(button) {
	$(".table-body").append('<tr class="upload-row" id="upload_row"></tr>');
	$(".upload-row").append('<td class="sequence-number">' + (++itemTotal) + '</td>');
	$(".upload-row").append('<td class="item-name"><input type="text" name="item_name" required></td>');
	$(".upload-row").append('<td class="item-image"> <div class="image-preview"></div> <br> <label for="item_image" class="btn btn-secondary"> Chọn ảnh </label> <input type="file" id="item_image" name="item_image" required> </td>');
	$(".upload-row").append('<td class="item-quantity"><input type="number" name="quantity" required></td>');
	$(".upload-row").append('<td class="item-note"><input type="text" name="note" required></td>');
	$(".upload-row").append('<td></td>');
	$(".upload-row").append('<td></td>');
	$(".upload-row").append('<td><button class="item-save btn btn-success">Xong</button><hr><button class="item-cancel btn btn-danger">Hủy</button></td>');
	
	document.querySelector("#item_image").style.opacity = 0;

	button.disabled = true;

	$(".item-cancel").click(function() {
		$(".upload-row").remove();
		button.disabled = false;
		itemTotal-- ;
	});

	const IMAGE_INPUT = document.getElementById('item_image');
	const IMAGE_PREVIEW = document.querySelector('.image-preview');

	IMAGE_INPUT.addEventListener("change", function() {
		while(IMAGE_PREVIEW.firstChild) {
        IMAGE_PREVIEW.removeChild(IMAGE_PREVIEW.firstChild);
		}

		let curFiles = IMAGE_INPUT.files;

		if (IMAGE_INPUT.files === 0) {
			const para = document.createElement('p');
			para.textContent = 'No files currently selected for upload';
			IMAGE_PREVIEW.appendChild(para);
		} else {
			const file = curFiles[0];
			const para = document.createElement('p');
			
			if(validFileType(file)) {
				const image = document.createElement('img');
				image.src = URL.createObjectURL(file);
				image.style.width = "25%";


				IMAGE_PREVIEW.appendChild(image);

				button.disabled = false;

			} else {
				para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
				IMAGE_PREVIEW.appendChild(para);

				button.disabled = true;
			}
			
		}
		});
}

const FILE_TYPES = [
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/tiff",
    "image/webp",
];

function validFileType(file) {
    return FILE_TYPES.includes(file.type);
}

</script>