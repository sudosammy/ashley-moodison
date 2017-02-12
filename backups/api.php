<?php
require_once('api_config.php');
/*
This is all old code. I'm in the process of updating it to the new SQL handler.
It was using deprecated PHP functions to protect it against SQL injections.
I have followed the PHP docs and updated the code with the recommended equivalents.

The code now uses the mysqli_* functions which are "as good security-wise as parameterized queries"
- https://stackoverflow.com/questions/13026469/mysql-escape-string-vulnerabilities/13026651#13026651

- Robert
*/

if (!isset($_GET['token']) ||
    empty($_GET['token']) ||
    !isset($_GET['table']) ||
    empty($_GET['table'])) {

  header("HTTP/1.0 403 Forbidden");
  die("Invalid request");
}

// this script uses the mysqldump command.
// we need to make sure our database modes are sane
$sane_modes = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
if (isset($_GET['mode'])) {
  $mode = substr($_GET['mode'], 0, 20);
  $safe_mode = mysqli_real_escape_string($sql, $_GET['mode']);
  $query = 'SET SQL_MODE="' . $sane_modes . ',' . $safe_mode . '"';
  $sql->query($query);

  if (!empty($err = $sql->error)) {
    header("HTTP/1.0 403 Forbidden");
    die($err);
  }
}

// sanitise table param
if ($_GET['table'] === "accounts" ||
    $_GET['table'] === "messages" ||
    $_GET['table'] === "flag_table") {

  $safe_table = $_GET['table']; // this is safe, right?
} else {
  header("HTTP/1.0 403 Forbidden");
  die("Select a valid table");
}

// check credentials
$safe_token = mysqli_real_escape_string($sql, $_GET['token']);
$query = 'SELECT * FROM api WHERE token = "' . $safe_token . '" AND `table` = "' . $safe_table . '"';
$result = $sql->query($query);

if (!empty($err = $sql->error)) {
  header("HTTP/1.0 403 Forbidden");
  die($err);
}

$num_rows = $result->num_rows;
if ($num_rows !== 1) {
  header("HTTP/1.0 403 Forbidden");
  die("Invalid output rows: " . $num_rows);
}

// produce .sql file
$file_name = $safe_table . '-' . date('d-m-Y') . '.sql';
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $file_name . '"' );

$cmd = escapeshellcmd(DEV_PATH . 'mysqldump -u ' . DB_USER . ' --password=' . DB_PASS . ' ' . DB_DATABASE . ' ' . $safe_table);
passthru($cmd);
exit();
