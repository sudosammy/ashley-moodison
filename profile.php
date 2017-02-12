<?php
define('PUB', true);
require_once('includes/app_top.php');

$tdata += array(
	'page_title' => 'Profile',
);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	define('TEMPLATE', 'member.tpl'); // view a members profile

	$query = "SELECT username, admin, profile_image, `desc` AS description
						FROM accounts
						WHERE account_id = :id";
	$bind = array(
		'id' => $_GET['id'],
	);
	$sql->query($query, $bind);
	$smarty->assign($sql->fetch());

} else {
	// ensure logged in
	if (!$_SESSION['account']['logged_in']) {
		// need to WEB_ROOT this one otherwise
		// /profile/invalidid redirects to /profile/login and cause redirect loop
		gtfo(WEB_ROOT . 'login');
	}

	define('TEMPLATE', 'profile.tpl'); 	// view my profile

	$query = "SELECT credits, admin, profile_image, `desc` AS description, (SELECT flag FROM flag_table WHERE flag_id = 3) AS flag3
						FROM accounts
						WHERE account_id = :id";
	$bind = array(
		'id' => $_SESSION['account']['account_id'],
	);
	$sql->query($query, $bind);
	$smarty->assign($sql->fetch());
}

require_once('includes/app_bottom.php');
