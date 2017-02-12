<?php
require_once('../includes/config.php');

$query = "SELECT flag
				FROM flag_table
        WHERE flag_id = 1";
$sql->query($query);
$flag = $sql->fetch();
?>
<html>
  <meta charset="utf-8"/>
  <head>
    <title>Backup REST API</title>
  </head>

  <body>
    <h1><?php echo $flag['flag']; ?></h1>
  </body>
</html>
