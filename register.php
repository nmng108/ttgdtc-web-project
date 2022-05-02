<?php include "register.html";
    //day DL da nhap len server
    $email = $student_id = $cf_password = $password = $diachi = $name= $phone_number='';
    if(!empty($_POST)) {
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
        } 
        if(isset($_POST['address']) && $_POST['address'] != '') {
            $diachi = $_POST['address'];
        } 
        if(isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        if(isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if(isset($_POST['cf_password'])) {
            $cf_password = $_POST['cf_password'];
        }
        if(isset($_POST['student_id'])) {
            $student_id= $_POST['student_id'];
        }
        if(isset($_POST['phone_number'])) {
            $phone_number = $_POST['phone_number'];
        }
        // dieu kien dang ki thanh cong la nhap mat khau 2 lan dung
        if($password == $cf_password ) {
            // dang ki thanh cong, chuyen dan trang dang nhap
            header('Location: login.php');
            // ket noi toi csdl 
            $connect = new mysqli("localhost", "root","","bai_tap_lon");
            // cho phep nhap ten tieng viet
            mysqli_set_charset($connect,"utf8");
            // neu ket noi khong thanh cong
            if($connect->connect_error)  {
                var_dump($connect->connect_error);
                die();
            }
            // them du lieu vua dang kivao co so du lieu
            $query = "INSERT INTO users(email, f_name, phone_number, password_, address_, student_ID) 
            VALUE('".$email."','".$name."','".$phone_number."','".$password."','".$diachi."','".$student_id."')";
            mysqli_query($connect, $query);
            mysqli_close($connect);

        }  
    } 
    
?>


<!-- GET: dữ liệu sẽ được đẩy lên URL, dữ liệu đẩy lên khá nhỏ -->
<!-- POST: không đẩy lên URL nên che dấu được thông tin, dữ liệu đẩy lên lớn -->
