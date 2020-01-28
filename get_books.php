<?php
	require 'conn.php';
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	//$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	//$offset = ($page-1)*$rows;
	$result = array();

    //$user = 'woo';
	//$rs = mysql_query("select count(*) from data");
	//$row = mysql_fetch_row($rs);
	//$result["iTotalRecords"] = $row[0];
	//$rs = mysql_query("select * from data limit $offset,$rows");
  //if( empty($user) ) {
  //  $whereclause = "where user = '$user'";
  //} else {
    $whereclause = "";
  //}
  $sql = "SELECT * FROM `books`";
	$rs = $conn -> query( $sql );

	$items = array();
	while($row = mysqli_fetch_array($rs)){
	    //echo json_encode($row);
		array_push($items, $row);
	}
	$result["entries"] = $items;
        header("Content-type: application/json");
        header("Cache-Control: no-cache, must-revalidate");

	echo json_encode($result);

?>
