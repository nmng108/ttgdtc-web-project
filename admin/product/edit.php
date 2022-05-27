<?php
$title = 'Cập nhật thông tin dụng cụ';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

// Handle form inputs sent from this file.
if(!empty($_POST)){
    $query = 
		"UPDATE products 
		SET availableQuantity = '" . $_POST['availableQuantity'] . "', 
        itemName = '" . $_POST['itemname'] . "',
        description = '" . $_POST['description'] . "'
			WHERE itemCode = ".$_GET['id'].""
		;
	$request = run_mysql_query($query);
	if ($request === true) {
		header('Location: ./');
	} else {
		die("Cannot update the products");
	}
}
?>
<br>
<br>

<?php
if (isset($_GET['id'])) {
	$requestNumber = $_GET["id"];
} else {
	exit("ITEM CODE IS NULL");
}


if($requestNumber != '') {
	$query = "SELECT * FROM products
			WHERE itemCode = $requestNumber";
	$request = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

	if(count($request) == 1) {
		$request = $request[0];
	} else {
		?>
		<script>
			console.log("NULL RESULT");
		</script>
		<?php
	}
}

// Get all status to create status options.
$sql = "SELECT * FROM products";
$all_status = run_mysql_query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Trạng thái dụng cụ</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
			</div>
			<div class="row">
				<form method="post" style="margin-left: 20px;">
                    <div class="form-group">
                    <label for="usr">Tên:</label><br>
						<input type="text" class="form-control" name="itemname" value="<?=$request['itemName']?>" required>
					</div>
                    <div class="form-group">
                    <label  for="usr">Mô tả:</label>
						<input type="text" class="form-control" name="description" value="<?=$request['description']?>" required>
					</div>
                    <div class="form-group">
						<label for="usr">Số lượng:</label><br>
						<input type="text" class="form-control" name="availableQuantity" value="<?=$request['availableQuantity']?>" required>
					</div>
					<button class="btn btn-success">Xác nhận</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
require_once('../layouts/footer.php');
?>