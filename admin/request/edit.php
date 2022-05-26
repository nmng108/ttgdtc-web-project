<?php
$title = 'Cập nhật yêu cầu';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");
include_once("$root_dir/request/manager.php");

// Handle form inputs sent from this file.


?>
<br>
<br>

<?php
// Get information about current request
$request = [];

if(isset($_GET['request'])) {
	$query = "SELECT * FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID 
			WHERE requestNumber = ".$_GET['request'];
	$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

	if(count($result) == 1) {
		$request = $result[0];
	} else {
		?>
		<script>
			console.log("NULL RESULT");
		</script>
		<?php
	}
} else {
	exit("REQUEST NUMBER IS NULL");
}

// Get all status to create status options.
$sql = "SELECT * FROM RequestStatus 
		WHERE statusName NOT IN (".get_invalid_status($request['statusName']).")
		ORDER BY statusID";
$all_status = run_mysql_query($sql)->fetch_all(MYSQLI_ASSOC);

// Remove invalid status.
function get_invalid_status($current_status) {
	switch ($current_status) {
		case 'SENT': return "'RETURNED'";
		
		case 'APPROVED': return "'CANCELED', 'SENT'";
		
		case 'RETURNED': return "'SENT', 'CANCELED', 'APPROVED'";
	}
}
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Cập nhật yêu cầu</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
			</div>
			<div class="panel-body container">
				<form id="update_form_<?=$_GET['request']?>" method="post">
                    <div class="form-group">
						<label for="next_status">Trạng thái:</label>
						<select class="form-control" name="next_status" id="status" value="<?=$request['statusName']?>" onchange="" required>
							<?php
							foreach($all_status as $status) {
								?>
								<option id="status_option_<?=$status['statusName']?>" value="<?=$status['statusName']?>">
									<?=translated_status($status['statusName'])?>
								</option>
								<?php
							}
							?>
							<script>
								// Pre-select the current status of request
								$("#status_option_<?=$request['statusName']?>").attr('selected', true);
							</script>
						</select>
					</div>
                    <div class="form-group">
						<label for="note">Ghi chú:</label>
						<textarea row="2" class="form-control" name="note" value=""><?=$request['note']?></textarea>

						<input type="text" name="request_number" value="<?=$request['requestNumber']?>" hidden>
						<input type="text" name="current_status" value="<?=$request['statusName']?>" hidden>
					</div>
					<?php
					if ($status['statusName'] != 'APPROVED') {
						?>
						<button class="btn btn-danger" onclick="process_deletion()">Xóa</button>
						<?php
					}
					?>
					<button type="button" name="submit" class="btn btn-success" onclick="process_update()">Xác nhận</button>
					<div class="notif"></div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
require_once('../layouts/footer.php');
?>
<script>
var request_number = '<?=$_GET['request']?>';
var current_status = '<?=$request['statusName']?>';
var old_note = '<?=$request['note']?>';

function process_update() {
	var next_status = $("#update_form_" + request_number + " select[name='next_status']").val();
	let new_note = $("#update_form_" + request_number + " textarea[name='note']").val();

	$(document).ready(function() {
		$ajax_request = $.ajax({
			type : 'POST',
			url : "process_status_change.php",
			data : { request_number : request_number, 
					current_status : current_status, 
					next_status : next_status,
					old_note : old_note,
					new_note : new_note },
			dataType : 'json',
		});

		$ajax_request.done(function(response) {
			console.log(response);
			if (response.hasSucceeded == true) {
				$(".notif").css('color', "green");
				$(".notif").html(response.message);

				setTimeout(function() {
					window.location.href = './';
				}, 1000);
			} else {
				$(".notif").css('color', "green");
				$(".notif").html(response.message);
			}
			setTimeout(function() {
				$(".notif").html("");
			}, 3000);
		});

		$ajax_request.fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(errorThrown);
		});
	});

}

function process_deletion() {
    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "<?=$root_dir?>/request/delete_request.php",
            data : { request_number : request_number },
			dataType : "json",
        });

        $ajax_request.done(function(response) {
            console.log(response);
			if (response['hasSucceeded'] == true) {
				window.location.href = "./";
			} else {
				$(".notif").css('color', "red");
				$(".notif").html("Xóa không thành công");
			}
		});

        $ajax_request.fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(errorThrown);
		});
	});
}
</script>