<?php
require_once('../includes/config.php');
header('Content-Type: application/json');
error_reporting(0);

function text2ascii($text) {
	return array_map('ord', str_split($text));
}

function cipher($plaintext, $key) {
	$key = text2ascii($key);
	$plaintext = text2ascii($plaintext);
	$keysize = count($key);
	$input_size = count($plaintext);
	$cipher = "";

	for ($i = 0; $i < $input_size; $i++)
		$cipher .= chr($plaintext[$i] ^ $key[$i % $keysize]);
	return $cipher;
}

if (!isset($_POST['message'])) {
	header("HTTP/1.0 403 Forbidden");
	die();
}

if (!isset($_SESSION['account']['admin']) || !$_SESSION['account']['admin']) {
	header("HTTP/1.0 403 Forbidden");
	die();
}

$message = printable($_POST['message']);
if (empty($message)) {
	header("HTTP/1.0 403 Forbidden");
	echo 'Invalid message.';
	die;
}

// we b64 this to give an accurate representation of what we will need to store in the db
// we tell the user a max of 350 chars becasue it gives a buffer (40%) for the b64 encode
if (strlen(base64_encode($message)) > 500) {
	header("HTTP/1.0 403 Forbidden");
	echo 'Maximum 300 characters.';
	die;
}

// validate 'to' field
if (!is_numeric($_POST['send_to'])) {
	header("HTTP/1.0 403 Forbidden");
	echo 'Not a valid admin.';
	die;
}

// got points?
$query = "SELECT credits
					FROM accounts
					WHERE account_id = :id";
$bind = array(
	'id' => $_SESSION['account']['account_id'],
);
$sql->query($query, $bind);
$credits = $sql->fetch()['credits'];

if ($credits <= 0) {
	$_SESSION['error'] = 'You have no points left!';
	header("HTTP/1.0 403 Forbidden");
	echo 'You have no more points left!';
	die;
}

// deduct point
$update_data = array(
	'credits' => --$credits,
);
$sql->update($update_data, 'accounts', "account_id = {$_SESSION['account']['account_id']}");

$query = "SELECT account_id, enc_key
					FROM accounts
					WHERE admin = 1
					AND account_id = :id";
$bind = array(
	'id' => $_POST['send_to'],
);
$sql->query($query, $bind);

if ($sql->num_rows() !== 1) {
	header("HTTP/1.0 403 Forbidden");
	echo 'Not a valid admin.';
	die;
}

// perform encryption and encoding
$enc_key = $sql->fetch()['enc_key'];
$enc_text = base64_encode(cipher($message, $enc_key));

$insert_data = array(
	'sender_id' => $_SESSION['account']['account_id'],
	'receiver_id' => $_POST['send_to'],
	'message' => $enc_text,
);
$sql->insert($insert_data, 'messages');

echo json_encode('Message sent successfully.');
