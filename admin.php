<?php
define('PUB', true);
define('TEMPLATE', 'admin.tpl');
require_once('includes/app_top.php');

// check if user is an admin - redirect them home if not
if (!isset($_SESSION['account']['admin']) || !$_SESSION['account']['admin']) {
	header('Location: ' . WEB_ROOT); // todo: update this to secure redirect function
}

$tdata += array(
	'page_title' => 'Control Panel',
	'flag' => printable(file_get_contents(FILE_ROOT . '../flag2.txt')), // get flag from outside web root
	'account_id' => $_SESSION['account']['account_id'],
);

// get number of account credits
$query = "SELECT credits
					FROM accounts
					WHERE account_id = :id";
$bind = array(
	'id' => $_SESSION['account']['account_id'],
);
$sql->query($query, $bind);
$smarty->assign($sql->fetch());

// generate dropdown
$query = "SELECT account_id, username
					FROM accounts
					WHERE admin = 1";
$sql->query($query);

while ($row = $sql->fetch()) {
	// PDO supports this automatically - I should update my handler to make use of that
	$admin_list[$row['account_id']] = ucwords($row['username']);
}

$smarty->assign('admin_list', $admin_list);
$smarty->assign('own_id', $_SESSION['account']['account_id']);

require_once('includes/app_bottom.php');
