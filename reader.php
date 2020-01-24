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
  if( $_POST['submit'] != 'First' ) {
    if( $_POST['submit'] == "Next" ) {
      $page++;
    } else {
      $page--;
    }
  } else {
    $page = 1;
  }
  setcookie("user","woo,$page",time()+3600*24*30);
}
echo "<html><head><title>Reader</title>";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./_css/home.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
  <div class="container" >
<?php
require('conn.php');
$sql = "SELECT * FROM books WHERE position_order = $page ";
$sections = $conn -> query($sql);
echo "<div class='content'>";
if( isset($_COOKIE["user"])) {
  ?>
<div id="navigation">
  <ul>
    <li><a href="sorter.php">Sorter</a></li>
    <li><a href="index.html">Editor</a></li>
  </ul>
</div>
<?php
}
while($section = $sections->fetch_assoc()){
  echo "<div id='header'>";
    echo "<div class='title'>";
      echo $section['header'];
        echo "<div class='page_num'>";
          echo "Page: $page";
          if( isset($section['date']) ) {
            $date = $section['date'];
            $date = date_create($date);
            $year = date_format($date,"Y");
            echo "<br />Year: $year";
          }
        echo "</div>";
    echo "</div>";
  echo "</div>";
echo "<p/>";
if( $section['image_url'] != "" ) {
  $figures = explode(",",$section['image_url']);
  $num_figures = sizeof($figures);
  if( $num_figures == 1 ) {
      $src = urlencode($figures[0]);
      $image = "./figures/$src";
      echo "<center>";
      echo "<img src=$image style=\"width:500px;height:300px;\" />";
      echo "<p />";
      echo "<h3>$src</h3><p />";
      echo "</center>";
    } else {
      $width = 800/$num_figures;
      $height = $width;
       ?>
       <center>
      <table>
      <tbody>
      <tr>
        <?php for($i=0;$i<$num_figures; $i++) {
          $src = urlencode($figures[$i]);
          $image = "./figures/$src";
          ?> <td> <?php echo "<img src=$image style=\"width:200px;height:200px;\" class=\"rotateimg90\"/>"; ?></td><?php
        } ?>
      <tr>
      <tr>
        <?php for($i=0;$i<$num_figures; $i++) {
          $src = urlencode($figures[$i]);
          ?> <td> <?php echo "$src"; ?></td><?php
        } ?>
      </tr>
      </tbody>
      </table>
    </center>
      <?php
    }
}
echo "<div class='text-wrapper'>";
echo $section['data'];
echo "</div>";
echo "<p />";
echo "<center>";
}

?>
<form action='' method='POST'>

  <?php
    if( $page > 1 ) { ?>
    <input type='submit' name='submit' value='First'/> |
    <input type='submit' name='submit' value='Prev' /> |
  <?php } ?>
    <input type='submit' name='submit' value='Next'/>
</form>
</div>
<p /><p />
<div id="footer" >
  <?php
  include 'git-info.php';
  ?>
</div>
