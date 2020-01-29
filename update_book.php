<?php
require 'config.ini.php';
$id = intval($_REQUEST['id']);
$header = htmlspecialchars($_REQUEST['header']);
$data = htmlspecialchars($_REQUEST['data']);
$image_url = htmlspecialchars($_REQUEST['image_url']);
$date = htmlspecialchars($_REQUEST['date']);

include 'conn.php';
$table = $config['DATABASE_TABLE'];
$sql = $conn->prepare("update $table set header=?,data=?, image_url=?, date=? where id=?");
$sql->bind_param("ssssi",$header,$data, $image_url, $date, $id);

if ($sql->execute()){
	echo json_encode(array(
		'id' => $id,
		'header' => $header,
		'data' => $data,
		'image_url' => $image_url,
		'date' => $date
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured: ' . mysqli_error($conn)));
}
?>
