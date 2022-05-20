<?php 
session_start();

$title = 'Yêu cầu';
$root_dir = "..";

include_once("$root_dir/includes/user_layouts/layout.php");
include_once("$root_dir/includes/user_layouts/header.php");

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

if (!isset($_GET['cat'])) die("Not yet received category.");

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
</script>
<br>
<br>

<?php
$user_info = NULL;
$class_info = NULL;
$submission_disabled = false;

// Get student information from the Students table
$query = "SELECT * FROM Students WHERE studentID = ".$_SESSION[USERID];
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    $user_info = $result->fetch_array();
}

// handle name
if ($user_info['firstName'] === NULL) {
    $user_info['fullName'] = $user_info['lastName'];
} else {
    $user_info['fullName'] = $user_info['firstName'] . " " . $user_info['lastName'];
}

// handle school name
switch ($user_info['school']) {
    case "UET":
        $user_info['school'] = "ĐHCN";
        break;
    case "ULIS":
        $user_info['school'] = "ĐHNN";
        break;
    case "IS":
        $user_info['school'] = "Trường Quốc Tế";
        break;
    case "UEd":
        $user_info['school'] = "ĐHGD";
        break;
    case "UEB":
        $user_info['school'] = "ĐHKT";
        break;
    case "SoL":
        $user_info['school'] = "Khoa Luật";
        break;
}

// handle phone number
$user_info['phoneNumber'] = "0" . $user_info['phoneNumber'];


// Get student's class information from the AttendingStudents table
$query = "SELECT * FROM AttendingStudents  WHERE studentID = ".$_SESSION[USERID];
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    $result = $result->fetch_array();

    // $user_info['subjectCode'] = $result['subjectCode'];
    // $user_info['classNumber'] = $result['classNumber'];
    $user_info['classCode'] = $result['classCode'];
}


// Get class information from the Classes table
if (isset($user_info['classCode'])) {
    $query = "SELECT * FROM Classes WHERE classCode = '".$user_info['classCode']."'";
    $result = run_mysql_query($query);

    if ($result->num_rows == 1) {
        $class_info = $result->fetch_array();
    }

    // handle date
    // week day number in php is decreased by 1 compares to it in database with the same day
    $current_day_of_week = date('w') + 1;
    $date_interval = $class_info['weekdayNumber'] - $current_day_of_week;

    // Get today's DateTime object.
    $date = date_create();
    // Calculate the nearest day that the class is going to take place.
    if ($date_interval >= 0) {
        $date = date_add($date, date_interval_create_from_date_string("$date_interval days"));
    } else {
        $date = date_add($date, date_interval_create_from_date_string((7 + $date_interval) ." days"));
    }
    
    $start_datetime = new DateTime(date_format($date, "Y-m-d") . " " . $class_info['startTime']);
    
    // Default format for applying datetime value to datetime-local input tag.
    $class_info['start_datetime'] = $start_datetime->format('Y-m-d\TH:i:s');
    
    // Get DateInterval object from studyTime.
    $study_time = explode(":", $class_info['studyTime']); //equivalent to split function.
    $study_time = date_interval_create_from_date_string($study_time[0]." hours ".$study_time[1]." minutes ".$study_time[2]." seconds");

    // Default format for applying datetime value to datetime-local input tag.
    $class_info['end_datetime'] = $start_datetime->add($study_time)->format('Y-m-d\TH:i:s');
} else {
    $submission_disabled = true;
}
?>

<div class="panel-body">
    <h4>Thông tin người gửi</h4>
	<form id="request_info" method="post">
        <label for="student_id">Mã sinh viên </label>
        <input type="text" id="" name="student_id" value="<?=$_SESSION[USERID]?>" disabled>
        <br>
        <br>
        <label for="full_name">Họ Tên </label>
        <input type="text" id="" name="full_name" value="<?=$user_info['fullName']?>" disabled>
        <br>
        <br>
        <label for="school">Trường </label>
        <input type="text" id="" name="school" value="<?=$user_info['school']?>" disabled>
        <br>
        <br>
        <label for="phone_number">Số điện thoại </label>
        <input type="number" id="" name="phone_number" value="<?=$user_info['phoneNumber']?>">
        <br>
        <br>
        <?php
        if (isset($user_info['classCode'])) {
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
            ?>
            <label for="class_code">Lớp học phần </label>
            <input type="text" id="" name="class_code" value="Không tham gia" disabled>
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
        <input type="button" class="btn" name="submit" value="Gửi yêu cầu" style="width: 20%;" onclick="process_submission()">	
        <span id="notification"></span>
    </form>
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

    // $("#request_info").submit((event)=> {
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

function process_submission() {
    $.ajax({
        type : "POST",
        url  : "../request/make_new_request.php",
        data : { student_id : '<?=$_SESSION[USERID]?>', 
                start_datetime : "<?=$class_info['start_datetime']?>",
                end_datetime : "<?=$class_info['end_datetime']?>",
                class_code : "<?=$class_info['classCode']?>",
                note : $("#request_info input[name=note").val(), // get from input
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
</script>