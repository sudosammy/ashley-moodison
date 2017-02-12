<?php
require_once('includes/config.php');

if (!defined('PUB') || PUB == false) {
	gtfo();
}

// load template
$smarty = new Smarty();

$smarty->setTemplateDir(TEMPLATE_DIR);
$smarty->setCompileDir(TEMPLATE_DIR_C);
$smarty->setConfigDir(TEMPLATE_CONFIG);
$smarty->setCacheDir(TEMPLATE_CACHE);

// Template data
$tdata = array(
	'site_title' => SITE_TITLE,
	'web_root' => WEB_ROOT,
	'copyright_date' => date('Y'),
);

if (isset($_SESSION['success'])) {
	$tdata += array('msg_success' => $_SESSION['success']);
	unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
	$tdata += array('msg_error' => $_SESSION['error']);
	unset($_SESSION['error']);
}
