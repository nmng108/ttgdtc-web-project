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

/**
 * Original format: Y/m/d H:i:s .
 */
function format_datetime_to_display(string $mysql_datetime) : string {
	return date_create($mysql_datetime)->format('H:i m/d/Y');
}
?>
<script>
	var invalid_characters = ["-", "+", "e"];

	var prevent_unexpected_characters = function(event) {
		// (on)keydown
		if (invalid_characters.includes(event.which)) {
			event.preventDefault();
		}
		// (on)input -> dont need to use the event parameter.
		// this.value = this.value.replace(/[e\+\-]/gi, "");
	}
</script>