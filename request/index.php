<?php
$root_dir = "..";
$title = 'Trang chủ';

include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");

?>
<br>
<br>
<br>

<?php
include_once("$root_dir/request/requests_table.php");
?>
<br>
<br>

<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>

<script>
function process_cancellation(request_number) {
    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../request/cancel_request.php",
            data : { request_number : request_number },
			dataType : "json",
        });

        $ajax_request.done(function(response) {
            console.log(response);
			if (response['hasSucceeded'] == true) {
				$("#status_" + request_number).html("Đã hủy");
				$("#cancel_button_" +request_number).remove();
			}
		});

        $ajax_request.fail(function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
		});
	});
}

function process_deletion(request_number) {
    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../request/delete_request.php",
            data : { request_number : request_number },
			dataType : "json",
        });

        $ajax_request.done(function(response) {
            console.log(response);
			if (response['hasSucceeded'] == true) {
				$("#request_" +request_number).remove();
			}
		});

        $ajax_request.fail(function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
		});
	});
}
</script>
