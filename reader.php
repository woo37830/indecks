<?php
$page = 1;
if( isset($_COOKIE["user"])) { // cookie has userid, page_num,...
    $value = $_COOKIE["user"];
    $tmp = explode(",", $value);
    $page = $tmp[1];
} else {
  setcookie("user", "woo,1", time()+3600*24*30);
}
if( isset($_POST['submit'])) {
  if( $_POST['submit'] == "Next" ) {
    $page++;
  } else {
    $page--;
  }
  setcookie("user","woo,$page",time()+3600*24*30);
}
echo "<html><head><title>Reader</title>";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
  <div class="container">
      <h3 class="text-center">Reader</h3>
<?php
require('conn.php');
$sql = "SELECT * FROM books WHERE position_order = $page ";
$sections = $conn -> query($sql);
echo "<center>";
while($section = $sections->fetch_assoc()){

echo $section['header'];
echo "<p/>";
echo "</center>";
if( $section['image_url'] != "" ) {
  $src = urlencode($section['image_url']);
  $image = "./figures/$src";
  echo "<center>";
  echo "<img src=$image style=\"width:800px;height:600px;\" />";
  echo "<p />";
  echo "<h3>$src</h3><p />";
  echo "</center>";
}
echo $section['data'];
echo "<p />";
echo "<center>";
}
?>
<form action='' method='POST'>
                <input type='submit' name='submit' value='Next'/>
</form>
<form action='' method='POST'>
                <input type='submit' name='submit' value='Prev' />
</form>
</div>
<p /><p />
