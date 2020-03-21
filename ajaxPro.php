<?php

require('conn.php');
$table = $config['DATABASE_TABLE'];

$items = $_POST['position'];
error_log("item count is: ".sizeof($items)."\n", 3, "/var/tmp/my-errors.log");
$i=1;
foreach( $items as $item ) {
    $sql = "Update $table SET position_order=".$i." WHERE id=".$item;
    if(mysqli_query($conn, $sql)){
      error_log("sql: ".$sql."\n", 3, "/var/tmp/my-errors.log");
    } else {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
	$i++;
}
mysql_close($conn);
?>
