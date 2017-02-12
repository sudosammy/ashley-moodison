<?php
ini_set('default_charset', 'utf-8');
header('Strict-Transport-Security: max-age=31536000 ; includeSubDomains');
header('Content-Type: text/html; charset=utf-8');
header('X-XSS-Protection: 1');
header('X-Frame-Options: deny');
set_time_limit('60');

define('LIVE', $_SERVER['HTTP_HOST'] != 'localhost');

if (LIVE) {
	// end with /
	define('WORKING_DIR', '/');
	// database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'unpriv_ashley');
	define('DB_PASS', 'njuxw4haW2pxvhHf');
	define('DB_DATABASE', 'ashley');
	define('DEV_PATH', '');
	// error reporting
	error_reporting(0);
} else {
	// end with /
	define('WORKING_DIR', '/ashley-moodison/');
	// database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'unpriv_ashley');
	define('DB_PASS', 'peterpeter');
	define('DB_DATABASE', 'ashley');
	define('DEV_PATH', 'c:\xampp\mysql\bin\\');
	// error reporting
	error_reporting(E_ALL & ~E_DEPRECATED);
}

//SQL
$sql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
