<?php
    $user = htmlspecialchars($_REQUEST['userid']);
    $paper = htmlspecialchars($_REQUEST['paper']); // use in query below after form for print completed.

	$result = array();
	include 'conn.php';
	$rs = mysqli_query($conn, "select measurement, header,page, data  from books where user = '$user' and paper = '$paper' order by measurement asc, header, page asc ");

	$items = array();
   $last_age = "0";
   $last_event = "";
	while($row = mysqli_fetch_array($rs)){
//      array_push($items, $row);
	 $age = $row["measurement"];
    $event = $row["header"];
    $data = $row["data"];
    if( $age != $last_age ) {
       $last_age = $age;
       $nameAttr = 'h1';
       $item = array();
       $item[$nameAttr] = "Age $age";
       array_push($items,$item);         
    }
    if( $age == $last_age && $event != $last_event ) {
       $last_event = $event;
       $nameAttr = 'h2';
       $item = array();
       $item[$nameAttr] = $event;
       array_push($items,$item);         
    }
      $nameAttr = 'text';
      $item = array();
      $item[$nameAttr] = $data;
      array_push($items,$item);       
    }
	$rs->free();

//    printf ("\nData Written\n\n"); 
 
 	$result["entries"] = $items;
        header("Content-type: application/json");
        header("Cache-Control: no-cache, must-revalidate");

   echo json_encode($result);

?>
