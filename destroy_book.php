<?php

$id = intval($_REQUEST['id']);

include 'conn.php';

// prepare SQL
// sql to delete a record
$sql = "DELETE FROM books WHERE id=$id";
$result = mysqli_query($conn,$sql);
if ($result) {
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>
