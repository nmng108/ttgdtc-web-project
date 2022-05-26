<?php
$title = 'Thêm/Sửa Tài Khoản Người Dùng';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

// Handle form inputs sent from this file.
if(!empty($_POST)){
    $query = 
		"UPDATE orders 
		SET statusID = '" . $_POST['status'] . "', 
			note = '".$_POST['note']."' 
		WHERE orderNumber = '".$_POST['order_number']."'";
	$result = run_mysql_query($query);
	if ($result === true) {
		header('Location: index.php');
	} else {
		die("Cannot update the request");
	}
}
?>
<br>
<br>
<?php
if (isset($_GET['order'])) {
	$orderNumber = $_GET['order'];
} else {
	exit("ORDER NUMBER IS NULL");
}


if($orderNumber != '') {
	$query = "SELECT * FROM Orders r JOIN OrderStatus rs ON r.statusID = rs.statusID
			WHERE orderNumber = $orderNumber";
	$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

	if(count($result) == 1) {
		$result = $result[0];
	} else {
		?>
		<script>
			console.log("NULL RESULT");
		</script>
		<?php
	}
}

// Get all status to create status options.
$sql = "SELECT * FROM OrderStatus ORDER BY statusID";
$all_status = run_mysql_query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Trạng thái yêu cầu</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
			</div>
			<div class="panel-body container">
				<form method="post">
                    <div class="form-group">
						<label for="status">Trạng thái:</label>
						<select class="form-control" name="status" id="status" value="<?=$status?>" required>
					  		<?php
							foreach($all_status as $status) {
								?>
								<option id="status_option_<?=$status['statusName']?>" value="<?=$status['statusID']?>">
									<?=$status['statusName']?>
								</option>
								<?php
							}
							?>
							<script>
								$("#status_option_<?=$result['statusName']?>").attr('selected', true);
							</script>
					  </select>
					</div>
                    <div class="form-group">
					  <label for="note">Ghi chú:</label>
					  <textarea id=""  type="text" class="form-control" name="note" value="<?=$result['note']?>"></textarea>
					</div>
					<input type="text" name="order_number" value="<?=$orderNumber?>" hidden>
					<button class="btn btn-success">Xác nhận</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
require_once('../layouts/footer.php');
?>