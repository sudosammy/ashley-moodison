<?php
define('PUB', true);
define('TEMPLATE', 'members.tpl');
require_once('includes/app_top.php');

$tdata += array(
	'page_title' => 'Our Members',
);

// search
if (isset($_GET['search'])) {
	if (empty(trim($_GET['username'])) && empty(trim($_GET['picture']))) {
		$_SESSION['error'] = 'Search for something...';
		gtfo('members');
	}

	if (!empty($_GET['username'])) {
		// search via username
		$query = "SELECT account_id, username, admin, profile_image, `desc` AS description
							FROM accounts
							WHERE username LIKE :username
							ORDER BY admin DESC
							LIMIT 1000";
		$bind = array(
			'username' => '%' . $_GET['username'] . '%',
		);
		$sql->query($query, $bind);

		$smarty->assign('member', $sql->fetch_all());

	} elseif (!empty($_GET['picture'])) {
		// search for images
		$pic_explode = explode('/', get_absolute_path(WEB_ROOT . 'images/uploads/' . $_GET['picture']));
		$root_explode = explode('/', get_absolute_path(WEB_ROOT));

		if (count($pic_explode) <= count($root_explode)) {
			$_SESSION['error'] = 'Cannot search outside of web root.';
			gtfo('members');
		}

		$search_path = FILE_ROOT . 'images/uploads/' . $_GET['picture'] . '*.*';
		foreach (glob($search_path) as $filename) {
			$images[] = array(
				'profile_image' => base64_encode(file_get_contents($filename)),
			);
		}
		$smarty->assign('member_images', $images);
		$smarty->assign('search_path', printable($search_path));
	}
} else {
	// no search
	$query = "SELECT account_id, admin, username, profile_image, `desc` AS description
						FROM accounts
						ORDER BY admin DESC, account_id DESC";
	$sql->query($query);

	$smarty->assign('member', $sql->fetch_all());
}

require_once('includes/app_bottom.php');
