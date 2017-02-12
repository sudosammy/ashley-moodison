<?php
require_once('../includes/config.php');

if (!$_SESSION['account']['logged_in']) {
	gtfo();
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
	gtfo('../profile');
}

// deduct point
$update_data = array(
	'credits' => --$credits,
);
$sql->update($update_data, 'accounts', "account_id = {$_SESSION['account']['account_id']}");

// load hints
$query = "SELECT hint_id, `text` AS the_hint
					FROM hints";
$sql->query($query);
$row = $sql->fetch_all();

$hints_to_show = 10;
$hints_to_show = $hints_to_show - $credits;

for ($i=0; $i < $hints_to_show; $i++) {
	echo $row[$i]['hint_id'] . '/10) ' . $row[$i]['the_hint'] . ' <a href="javascript:history.back()">[Go Back]</a><br><br>';
}
