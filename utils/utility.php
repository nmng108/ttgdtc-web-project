<?php

function fixSqlInject($sql) {
	$sql = str_replace('\\', '\\\\', $sql);
	$sql = str_replace('\'', '\\\'', $sql);
	return $sql;
}

function getGet($key) {
	$value = '';
	if(isset($_GET[$key])) {
		$value = $_GET[$key];
		$value = fixSqlInject($value);
	}
	return trim($value);
}

function getPost($key) {
	$value = '';
	if(isset($_POST[$key])) {
		$value = $_POST[$key];
		$value = fixSqlInject($value);
	}
	return trim($value);
}

function getRequest($key) {
	$value = '';
	if(isset($_REQUEST[$key])) {
		$value = $_REQUEST[$key];
		$value = fixSqlInject($value);
	}
	return trim($value);
}

function getCookie($key) {
	$value = '';
	if(isset($_COOKIE[$key])) {
		$value = $_COOKIE[$key];
		$value = fixSqlInject($value);
	}
	return trim($value);
}

function getSecurityMD5($pwd) {
	return md5(md5($pwd).PRIVATE_KEY);
}

function getUserToken() {
	if(isset($_SESSION['student'])) {
		return $_SESSION['student'];
	}
	$token = getCookie('token');
	$sql = "SELECT * from UserTokens inner join students on UserTokens.userID = students.studentID where token = '$token'";
	$item = executeResult($sql, true);
	if($item != null) {
		$_SESSION['student'] = $item;
		return $item;
	}
	return null;
}

function getAdminToken() {
	if(isset($_SESSION['admin'])) {
		return $_SESSION['admin'];
	}
	$token = getCookie('token');
	$sql = "SELECT * from UserTokens inner join admins on UserTokens.userID = admins.adminID where token = '$token' ";
	$item = executeResult($sql, true);
	if($item != null) {
		$_SESSION['admin'] = $item;
		return $item;
	}
	return null;
}

