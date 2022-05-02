<?php include "login.html";
$user_name = $pass = '';
$res = false;
if(isset($_POST['email'])) {
    $user_name = $_POST['email'];
} 
if(isset($_POST['password'])) {
    $pass = $_POST['password'];
}

$connect = new mysqli("localhost", "root","","bai_tap_lon");
mysqli_set_charset($connect,"utf8");
if($connect->connect_error)  {
    var_dump($connect->connect_error);
    die();
}
$query = "SELECT email, password_ FROM users";
$result = mysqli_query($connect, $query);
$data = array();
while($row = mysqli_fetch_array($result, 1)) {
    $data[] = $row;
}
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['email'] == $user_name && $data[$i]['password_'] == $pass) {
        $res = true;
        break;
    }
}
if ($res == true) {
    header('Location: index.php');
}

?>
