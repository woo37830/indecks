<?php

require 'config.ini.php';
$header = htmlspecialchars($_REQUEST['header']);
$data = htmlspecialchars($_REQUEST['data']);
$image_url = htmlspecialchars($_REQUEST['image_url']);
$date = htmlspecialchars($_REQUEST['date']);

include 'conn.php';
$table = $config['DATABASE_TABLE'];
$stmt = $conn->prepare("insert into $table(header,data,image_url,date) values(?,?,?,?)");
$stmt->bind_param("ssss",$header,$data,$image_url,$date);
$result = $stmt->execute();

if ($result){
	echo json_encode(array(
		'header' => $header,
		'data' => $data,
		'image_url' => $image_url,
		'date' => $date
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured: ' ));
}
?>
