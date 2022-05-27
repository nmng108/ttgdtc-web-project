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
} else {
    ?>
    Chưa có sản phẩm
    <?php
    exit();
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

<div class="infor">
    <h4>Thông tin người gửi</h4>
    <form id="checkout_info" method="post">
        <!-- common fields -->
        <div class="form-group">
        <label for="student_id">Mã sinh viên </label>
        <input class="form-control"   type="text" name="student_id" value="<?=$_SESSION[USERID]?>" disabled>
        </div>
        <div class="form-group">
        <label for="full_name">Họ Tên </label>
        <input class="form-control" type="text" name="full_name" value="<?=$user_info['fullName']?>" disabled>
        </div>
        <div class="form-group">
        <label for="school">Trường </label>
        <input class="form-control"type="text" name="school" value="<?=$user_info['school']?>" disabled>
        </div>
        <div class="form-group">
        <label for="phone_number">Số điện thoại </label>
        <input class="form-control" type="number" name="phone_number" value="<?=$user_info['phoneNumber']?>" disabled>
        </div>

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
                <div class="form-group">
                <label for="class_code">Lớp học phần </label>
                <input class="form-control" type="text" name="class_code" value="<?=$user_info['classCode']?>" disabled>
                </div>
                <div class="form-group">
                    <label for="class_start_datetime">Thời gian mượn: </label>
                    <input type="datetime-local" name="class_start_datetime" value="<?=$class_info['start_datetime']?>" disabled>
                </div>

                <div class = "form-group">
                    <label for="class_end_datetime">Thời gian trả: </label>
                    <input class="form-control" type="datetime-local" name="class_end_datetime" value="<?=$class_info['end_datetime']?>" disabled>   
                </div>
                <?php
            } else {
                $submission_disabled = true;
                ?>
                <div class="">
                <label for="class_code">Lớp học phần </label>
                <input class = "form-group"type="text" name="class_code" value="Không tham gia" disabled>
                </div>
                <p style= "color: red; "id="notif_msg">*Không thể gửi yêu cầu do không tham gia lớp học nào</p>
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
        }
        if ($_GET['cat'] == UNIFORM) {
            ?>
            <div class="form-group">
            <label for="payment_method">Phương thức thanh toán: </label>
            <select name="payment_method" id="payment_method" required>
                <option selected disabled hidden>Chọn</option>
                <option value="BANKING">Chuyển khoản</option>
                <option value="DIRECT">Trực tiếp</option>
            </select>
            </div>
            <?php
        }
        ?>
        <!-- common fields -->
        <div class="form-group">
        <label for="note">Ghi chú </label>
        <input class = "form-control" type="text" name="note" value="">
        </div>
        <!-- Doesn't work with cat = UNIFORM ??? -->
        <input type="button" class="btn" name="submit" value="Gửi yêu cầu" style="width: 20%;" onclick="process('<?=$_GET['cat']?>')">	
        <span id="notification"></span>
    <?php
    ?>
    </form>
</div>
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
<script src="process.js"></script>
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

function process(category) {
    <?php
    if (!isset($_SESSION[USERID])) {
        ?>
        return;
        <?php
    }
    ?>

    let student_id = <?=$_SESSION[USERID]?>;
    let note = $("#checkout_info input[name=note").val();

    if (category === '<?=SPORT_EQUIPMENT?>') {
        <?php
        if (!isset($class_info) || !isset($user_info)) {
            ?>
            return;
            <?php
        }
        ?>

        let start_datetime = '<?=$class_info['start_datetime']?>';
        let end_datetime = '<?=$class_info['end_datetime']?>';
        let class_code = '<?=$user_info['classCode']?>';

        process_request_submission(student_id, start_datetime, end_datetime, class_code, note);
    }

    if (category === '<?=UNIFORM?>') {
        let payment_method = $("#payment_method").val();
console.log("pressed");
        process_order_submission(student_id, payment_method, note);
    }
}
</script>