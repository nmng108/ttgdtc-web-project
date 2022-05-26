<?php
/* 
 * No longer use this file
 */
session_start();

$root_dir = "../..";

require_once("$root_dir/includes/utilities.php");
require_once("$root_dir/database/manager.php");

// $user = getUserToken();
// if($user != null) {
//     if ($user['role_id'] == 2) {
//         header('Location: ../user');
//         die();
//     } else {
//         header('Location:../admin');
//         die();

//     }
// } 

if(!empty($_POST)) {
	$action = $_POST['action'];
	switch ($action) {
		case 'delete':
			deleteUser();
			break;
	}
}

function deleteUser() {
	// $id = getPost('id');
	// $updated_at = date("Y-m-d H:i:s");
	// $sql = "update Users set deleted = 1, updated_at = '$updated_at' where id = $id";
	// execute($sql);

	if (!isset($_POST['id'])) return false;
	
	$query = "DELETE FROM Students WHERE studentID = ".$_POST['id'];
	
	return run_mysql_query($query);
}