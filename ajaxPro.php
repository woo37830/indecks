<?php

require('conn.php');

$items = $_POST['position'];

$i=1;
foreach( $items as $item ) {
    $sql = "Update books SET position_order=".$i." WHERE id=".$item;
    $conn->query($sql);

	$i++;
}

?>
