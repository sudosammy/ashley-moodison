<?php
$start_time = microtime(true);

ini_set('default_charset', 'utf-8');
header('Strict-Transport-Security: max-age=31536000 ; includeSubDomains');
header('Content-Type: text/html; charset=utf-8');
header('X-XSS-Protection: 1');
header('X-Frame-Options: deny');
set_time_limit('60');
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
session_start();

define('LIVE', $_SERVER['HTTP_HOST'] != 'localhost');

if (LIVE) {
	// end with /
	define('WORKING_DIR', '/');
	// database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'priv_ashley');
	define('DB_PASS', 'YvscGRYVL4Hza7AN');
	define('DB_DATABASE', 'ashley');
	// error reporting
	error_reporting(0);
} else {
	// end with /
	define('WORKING_DIR', '/ashley-moodison/');
	// database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_DATABASE', 'ashley');
	// error reporting
	error_reporting(E_ALL & ~E_DEPRECATED);
}

/******************************
	Specific Defines
******************************/
define('SITE_TITLE', 'Ashley Moodison');
define('DATES', 'dmY'); //American Alternative mdY

/******************************
	Generic Defines
******************************/
define('FILE_ROOT', $_SERVER['DOCUMENT_ROOT'] . WORKING_DIR);
define('IMAGE_UPLOAD', FILE_ROOT . 'images/uploads/');

//Construct URL
$SSL = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
define('WEB_ROOT', $SSL . $_SERVER['HTTP_HOST'] . WORKING_DIR);
// Refer define
if (isset($_SERVER['HTTP_REFERER'])) {
	// yo yo yo yo need to fix this, we shouldn't be trusting this var. use WEB_ROOT to confirm it's in a location we cool with
	define('REFERER', $_SERVER['HTTP_REFERER']);
} else {
	define('REFERER', WEB_ROOT);
}

// Template related
define('INCLUDES_DIR', FILE_ROOT . 'includes/');
define('TEMPLATE_DIR', FILE_ROOT . 'templates/');
define('TEMPLATE_DIR_C', TEMPLATE_DIR . 'templates_c/');
define('TEMPLATE_CONFIG', INCLUDES_DIR . 'config/');
define('TEMPLATE_CACHE', TEMPLATE_DIR . 'cache/');


/******************************
	Files
******************************/
require_once(INCLUDES_DIR . 'Smarty.class.php');
require_once(INCLUDES_DIR . 'functions.php');
require_once(INCLUDES_DIR . 'pdo.php');

/******************************
	Validate IP Addresses
******************************/
define('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']);

/******************************
	Startup
******************************/
//SQL
$sql = new sql();
