<?php
require_once('../includes/config.php');
header('Content-Type: application/json'); // must go under app_top because app_top sets content type as text/html
error_reporting(0);

if (!isset($_SESSION['account']['admin']) || !$_SESSION['account']['admin']) {
  gtfo();
}

// get key
$query = "SELECT enc_key
				  FROM accounts
		      WHERE account_id = :id";
$bind = array(
	'id' => $_SESSION['account']['account_id'],
);
$sql->query($query, $bind);
$enc_key = $sql->fetch()['enc_key'];

echo json_encode($enc_key);
