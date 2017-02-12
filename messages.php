<?php
require_once('includes/config.php');
header('Content-Type: application/json');
error_reporting(0);

if (!isset($_SESSION['account']['admin']) || !$_SESSION['account']['admin']) {
	gtfo(WEB_ROOT . 'login');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  gtfo(WEB_ROOT . 'login');
}

// get messages
$query = "SELECT
						a.message_id,
						a.message,
						a.timestamp,
						a.receiver_id,
						b.username AS sender
					FROM messages AS a
					LEFT JOIN accounts AS b
					ON a.sender_id = b.account_id
					WHERE a.receiver_id = :id
        	ORDER BY a.timestamp ASC";
$bind = array(
	'id' => $_GET['id'],
);
$sql->query($query, $bind);

while ($row = $sql->fetch()) {
	$row['timestamp'] = pretty_date($row['timestamp']);
  $objs[$row['message_id']] = $row;
}

echo json_encode($objs);
