<?php
require_once('../includes/config.php');

if (!isset($_POST['update'])) {
	gtfo();
}

if (!$_SESSION['account']['logged_in']) {
	gtfo();
}

$description = printable($_POST['description']);
if (empty($description)) {
	$_SESSION['error'] = 'Invalid description';
	gtfo('../profile');
}

if (strlen($description) > 200) {
	$_SESSION['error'] = 'Maximum 200 characters.';
	gtfo('../profile');
}

// check if description is NULL and we need to award points
$query = "SELECT credits, `desc`
					FROM accounts
					WHERE account_id = :id";
$bind = array(
	'id' => $_SESSION['account']['account_id'],
);
$sql->query($query, $bind);

while ($row = $sql->fetch()) {
	$credits = ($row['desc'] == NULL) ? $row['credits'] + 10 : $row['credits'];
}

$update_data = array(
	'desc' => $description,
	'credits' => $credits,
);
$sql->update($update_data, 'accounts', "account_id = {$_SESSION['account']['account_id']}");

$_SESSION['success'] = 'Description updated.';
gtfo('../profile');
