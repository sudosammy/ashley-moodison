<?php
require_once('../includes/config.php');

$username = ucwords(strip_chars($_POST['username']));
if (empty($username)) {
	$_SESSION['error'] = 'Incorrect username';
	gtfo('../login');
}

if (empty($_POST['password']) || strlen($_POST['password']) < 4) {
	$_SESSION['error'] = 'Incorrect password';
	gtfo('../login');
}

$query = "SELECT account_id, admin, salt, password
					FROM accounts
					WHERE username = :username";
$bind = array(
	'username' => $username,
);
$sql->query($query, $bind);

if ($sql->row_count() != 1) {
	$_SESSION['error'] = 'Incorrect username and password combination';
	gtfo('../login');
}

while ($row = $sql->fetch()) {
	$expected_hash = new_hash($_POST['password'], $row['salt']);

	if ($expected_hash != $row['password']) {
		$_SESSION['error'] = 'Incorrect username and password combination';
		gtfo('../login');
	}

	$account_id = $row['account_id'];
	$admin = $row['admin'];
}

// Correct
$user = array(
	'logged_in' => true,
	'account_id' => $account_id,
	'username' => $username,
	'admin' => $admin, // this is 1/0
);
$_SESSION['account'] = $user;

// update things in the user table
$update_data = array(
	'last_login' => date('Y-m-d G:i:s'),
);
$sql->update($update_data, 'accounts', "account_id = ${account_id}");

$_SESSION['success'] = 'Logged in!';
gtfo('../profile');
