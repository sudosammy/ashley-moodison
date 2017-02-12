<?php
define('PUB', true);
define('TEMPLATE', 'login.tpl');
require_once('includes/app_top.php');

if (isset($_SESSION['account']) && $_SESSION['account']['logged_in']) {
	gtfo('profile');
}

$tdata += array(
	'page_title' => 'Login',
);

require_once('includes/app_bottom.php');
