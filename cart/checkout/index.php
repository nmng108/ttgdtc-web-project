<?php 
session_start();

$title = 'Yêu cầu';
$root_dir = "../..";

include_once("$root_dir/includes/user_layouts/layout.php");
include_once("$root_dir/includes/user_layouts/header.php");

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

if (!isset($_GET['cat'])) die("Not received category yet.");

$cart = get_cart_info_by_category($_SESSION[USERID], $_GET['cat'])->fetch_all(MYSQLI_ASSOC);
if (count($cart) > 0) {
?>
<br>
<br>
<?php
	if ($_GET['cat'] == SPORT_EQUIPMENT) {
        include_once("$root_dir/cart/sport_equipment_box_cart.php");
    } else if ($_GET['cat'] == UNIFORM) {
        include_once("$root_dir/cart/uniform_box_cart.php");
    }
}
?>
<script>
    $(".delete-button").each(function() {
        $(this).remove();
    });
    $(".edit-button").each(function() {
        $(this).remove();
    });
    $(".checkout-button").remove();
    $(".total-price-sub-cols").remove();
</script>
<br>
<br>

<?php
$user_info = NULL;
$class_info = NULL;
$submission_disabled = false;

include_once("$root_dir/cart/checkout/get_user_info.php");
?>

<div class="panel-body">
    <h4>Thông tin người gửi</h4>
    <form id="checkout_info" method="post">
        <label for="student_id">Mã sinh viên </label>
        <input type="text" name="student_id" value="<?=$_SESSION[USERID]?>" disabled>
        <br>
        <br>
        <label for="full_name">Họ Tên </label>
        <input type="text" name="full_name" value="<?=$user_info['fullName']?>" disabled>
        <br>
        <br>
        <label for="school">Trường </label>
        <input type="text" name="school" value="<?=$user_info['school']?>" disabled>
        <br>
        <br>
        <label for="phone_number">Số điện thoại </label>
        <input type="number" name="phone_number" value="<?=$user_info['phoneNumber']?>" disabled>
        <br>
        <br>

        <?php
        if ($_GET['cat'] == SPORT_EQUIPMENT) {
            // Get student's class code from the AttendingStudents table
            $query = "SELECT classCode FROM AttendingStudents  WHERE studentID = ".$_SESSION[USERID];
            $result = run_mysql_query($query);

            if ($result->num_rows == 1) {
                $result = $result->fetch_array();
                $user_info['classCode'] = $result['classCode'];
            }

            if (isset($user_info['classCode'])) {
                // Get class information(about time) from the Classes table
                include_once("$root_dir/cart/checkout/get_class_info.php");

                ?>
                <label for="class_code">Lớp học phần </label>
                <input type="text" name="class_code" value="<?=$user_info['classCode']?>" disabled>
                <br>
                <br>
                <div class="form-group">
                    <label for="class_start_datetime">Thời gian mượn: </label>
                    <input type="datetime-local" name="class_start_datetime" value="<?=$class_info['start_datetime']?>" disabled>
                </div>

                <div class = "form-group">
                    <label for="class_end_datetime">Thời gian trả: </label>
                    <input type="datetime-local" name="class_end_datetime" value="<?=$class_info['end_datetime']?>" disabled>   
                </div>
                <?php
            } else {
                $submission_disabled = true;
                ?>
                <label for="class_code">Lớp học phần </label>
                <input type="text" name="class_code" value="Không tham gia" disabled>
                <br>
                <br>
                <p id="notif_msg">Không thể gửi yêu cầu do không tham gia lớp học nào</p>
                <!-- <div class="form-group">
                    <label for="start_time">Thời gian mượn:</label>
                    <input type="time" class="" name="start_time" value="<?=date('H:i:s')?>">
                </div>
                <div class = "form-group">
                    <label for="start_date">Ngày mượn:</label>
                    <input type="date" class="" name="start_date" value="<?=date('Y-m-d')?>">   
                </div>

                <div class = "form-group">
                    <label for="end_datetime">Thời gian trả:</label>
                    <input type="datetime-local" class="" name="end_datetime" value="<?=date("Y-m-d\TH:i:s")?>" min="<?=date("Y-m-d\TH:i:s")?>">   
                </div> -->
                <?php  
            }
            ?>
            <label for="note">Ghi chú </label>
            <input type="text" name="note" value="">
            <br>
            <input type="button" class="btn" name="submit" value="Gửi yêu cầu" style="width: 20%;" onclick="process_request_submission()">	
            <span id="notification"></span>
        <?php
        }
        if ($_GET['cat'] == UNIFORM) {
            ?>
            <label for="payment_method">Phương thức thanh toán: </label>
            <select name="payment_method" id="payment_method" required>
                <option selected disabled hidden>Chọn</option>
                <option value="BANKING">Chuyển khoản</option>
                <option value="DIRECT">Trực tiếp</option>
            </select>
            <br>
            <br>
            <label for="note">Ghi chú </label>
            <input type="text" name="note" value="">
            <br>
            <input type="button" class="btn" name="submit" value="Gửi yêu cầu" style="width: 20%;" onclick="process_order_submission()">	
            <span id="notification"></span>
            <?php
        }
    
        ?>
    </form>
</div>
<?php
if ($_GET['cat'] == UNIFORM) {

}
?>
<!-- body START -->
<script src="<?="$root_dir/cart/data handler.js"?>"></script>
<?php
if ($submission_disabled) {
    ?>
    <script>$(".btn").prop("disabled", true);</script>
    <?php
} else {
    ?>
    <script>$(".btn").prop("disabled", false);</script>
    <?php
}


?>
<script>
    // $("#checkout_info").submit((event)=> {
    //     $.ajax({
    //         type : "POST",
    //         url  : "<?=$root_dir?>/request/make_new_request.php",
    //         data : { student_id : <?=$_SESSION[USERID]?>, 
    //                 start_datetime : "<?=$class_info['start_datetime']?>",
    //                 end_datetime : "<?=$class_info['end_datetime']?>",
    //                 class_code : "<?=$class_info['classCode']?>",
    //                 note : 0 // get from input
    //             },
    //         dataType : "json",
    //         success : function(result) {
    //             console.log(result);
    //         }
    //     });
    //     event.preventDefault();
    // });

function process_request_submission() {
    $.ajax({
        type : "POST",
        url  : "../request/make_new_request.php",
        data : { student_id : '<?=$_SESSION[USERID]?>', 
                start_datetime : "<?=$class_info['start_datetime']?>",
                end_datetime : "<?=$class_info['end_datetime']?>",
                class_code : "<?=$user_info['classCode']?>",
                note : $("#checkout_info input[name=note").val(), // get from input
            },
        dataType : "json",
        success : function(result) {
            console.log(result);
            if (result['isSuccessful']) {
                $("#notification").html("Successful. Wait 2s to redirect");
                $("#notification").css("color", "green");
                setTimeout(function() {
                    window.location.href = "../request";
                }, 2000);
            } else {
                $("#notification").html("Failed");
                $("#notification").css("color", "red");
                setTimeout(function() {
                    $("#notification").html("");
                }, 3000);
          }
        }
    });
    // return false;
}

function process_order_submission() {
    $.ajax({
        type : "POST",
        url  : "../order/make_new_order.php",
        data : { student_id : '<?=$_SESSION[USERID]?>', 
                phone_number : "<?=$user_info['classCode']?>",
                payment_method : $("#payment_method").val(),
                note : $("#checkout_info input[name=note]").val(), // get from input
            },
        dataType : "json",
        success : function(result) {
            console.log(result);
            if (result['isSuccessful']) {
                $("#notification").html("Successful. Wait 2s to redirect");
                $("#notification").css("color", "green");
                setTimeout(function() {
                    window.location.href = "../order";
                }, 2000);
            } else {
                $("#notification").html("Failed");
                $("#notification").css("color", "red");
                setTimeout(function() {
                    $("#notification").html("");
                }, 3000);
          }
        }
    });
    // return false;
}
</script>