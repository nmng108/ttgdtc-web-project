<?php
session_start();
require_once('../../utils/utility.php');
require_once('../../database/dbhelper.php');

$user = getUserToken();
if($user != null) {
    if ($user['role_id'] == 2) {
        header('Location: ../user');
        die();
    } else {
        header('Location:../admin');
        die();

    }
} 

if(!empty($_POST)) {
	$action = getPost('action');
	switch ($action) {
		case 'delete':
			deleteUser();
			break;
	}
}

function deleteUser() {
	$id = getPost('id');
	$updated_at = date("Y-m-d H:i:s");
	$sql = "update Users set deleted = 1, updated_at = '$updated_at' where id = $id";
	execute($sql);
}