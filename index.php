<?php
define('PUB', true);
define('TEMPLATE', 'index.tpl');
require_once('includes/app_top.php');

$tdata += array(
	'page_title' => '',
);

$query = "SELECT account_id, username, profile_image, `desc` AS description
					FROM accounts
					ORDER BY account_id DESC
					LIMIT 2";
$sql->query($query);

$smarty->assign('member', $sql->fetch_all());

require_once('includes/app_bottom.php');
