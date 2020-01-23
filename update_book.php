<?php

$id = intval($_REQUEST['id']);
$paper = htmlspecialchars($_REQUEST['paper']);
$measurement = htmlspecialchars($_REQUEST['measurement']);
$header = htmlspecialchars($_REQUEST['header']);
$page = htmlspecialchars($_REQUEST['page']);
$data = htmlspecialchars($_REQUEST['data']);
$image_url = htmlspecialchars($_REQUEST['image_url']);
$date = htmlspecialchars($_REQUEST['date']);

include 'conn.php';
$sql = $conn->prepare("update books set paper=?,measurement=?,header=?,page=?, data=?, image_url=? date=? where id=?");
$sql->bind_param("sisissi",$paper,$measurement,$header,$page,$data, $image_url, $date, $id);

if ($sql->execute()){
	echo json_encode(array(
		'id' => $id,
		'paper' => $paper,
		'measurement' => $measurement,
		'header' => $header,
		'page' => $page,
		'data' => $data,
		'image_url' => $image_url,
		'date' => $date
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured: ' . mysqli_error($conn)));
}
?>
