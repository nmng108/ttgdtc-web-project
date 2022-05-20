<?php
// Specify the correct variables $root_dir base on the calling file before requiring/including this file.
// a session stores id, email, name of user.
define('USERID', 'user_id');
define('EMAIL', 'email');
define('NAME', 'name');
define('ROLE', 'role');

date_default_timezone_set("Asia/Bangkok");

function fix_sql_inject($sql) {
	$sql = str_replace('\\', '\\\\', $sql);
	$sql = str_replace('\'', '\\\'', $sql);
	return $sql;
}

function injection_fixed_query($str) {
	return isset($str) ? fix_sql_inject(trim($str)) : "";
}

function get_secure_md5($pwd) {
	return md5(md5($pwd));
}

function is_null_or_empty_string($str) {
    return ($str === null || trim($str) === '');
}

function user_defined_uniqid() {
	$lenght = 16; // lenght of the date() function's string below.
	date_default_timezone_set("Asia/Bangkok");

    // uniqid gives 13 chars, but you could adjust it to your needs.
	$bytes = random_bytes(ceil($lenght / 2));
    return date("Ymdhis", strtotime("now")) . substr(bin2hex($bytes), 0, $lenght);
}
