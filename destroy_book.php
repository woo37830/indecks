<?php
require 'config.ini.php';
$id = intval($_REQUEST['id']);

include 'conn.php';

// prepare SQL
// sql to delete a record
$table = $config['DATABASE_TABLE'];
$sql = "DELETE FROM $table WHERE id=$id";
$result = mysqli_query($conn,$sql);
if ($result) {
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>
