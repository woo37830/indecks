<?php

$user = htmlspecialchars($_REQUEST['user']);

$paper = htmlspecialchars($_REQUEST['paper']);
$measurement = htmlspecialchars($_REQUEST['measurement']);
$header = htmlspecialchars($_REQUEST['header']);
$page = htmlspecialchars($_REQUEST['page']);
$data = htmlspecialchars($_REQUEST['data']);
$image_url = htmlspecialchars($_REQUEST['image_url']);

include 'conn.php';

$stmt = $conn->prepare("insert into books(paper,measurement,header,page,data,user,image_url) values(?,?,?,?,?,?,?)");
$stmt->bind_param("sisisss",$paper,$measurement,$header,$page,$data,$user,$image_url);
$result = $stmt->execute();

if ($result){
	echo json_encode(array(
		'paper' => $paper,
		'measurement' => $measurement,
		'header' => $header,
		'page' => $page,
		'data' => $data,
		'image_url' => $image_url
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured: ' ));
}
?>
