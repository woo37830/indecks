<?php
require 'config.ini.php';
$page = 1;
if( isset($_COOKIE["page"])) { // cookie has userid, page_num,...
    $page = $_COOKIE["page"];
} else {
  setcookie("page", "1", time()+3600*24*30);
}
if( isset($_REQUEST['submit'])) {
  if( $_REQUEST['submit'] != 'First' ) {
    if( $_REQUEST['submit'] == "Next" ) {
      $page++;
    } else {
      $page--;
    }
  } else {
    $page = 1;
  }
  setcookie("page","$page",time()+3600*24*30);
}
echo "<html><head><title>Reader</title>";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./_css/home.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<LINK REL="stylesheet" HREF="_css/menu.css" id="styleid"/>
<script type="text/javascript">
  jQuery(function($){
           $( '.menu-btn' ).click(function(){
           $('.responsive-menu').toggleClass('expand')
           })
        });
        $(document).ready(function() {
          $("body").keydown(function(e) {
            if( e.which == 37 && $page > 1 ) {
              window.location = './reader.php?submit=Prev';
            }
            else if( e.which == 39 ) {
              window.location = './reader.php?submit=Next';
            }
          });
        });
        var start = null;
 window.addEventListener("touchstart",function(event){
   if(event.touches.length === 1){
      //just one finger touched
      start = event.touches.item(0).clientX;
    }else{
      //a second finger hit the screen, abort the touch
      start = null;
    }
  });
  window.addEventListener("touchend",function(event){
    var offset = 100;//at least 100px are a swipe
    if(start){
      //the only finger that hit the screen left it
      var end = event.changedTouches.item(0).clientX;

      if((end > start + offset) && $page > 1){
       //a left -> right swipe
       window.location = './reader.php?submit=Prev';
      }
      if(end < start - offset ){
       //a right -> left swipe
       window.location = './reader.php?submit=Next';
      }
    }
  });
</script>
</head>
<body>
  <div class="container" >
<?php
require('conn.php');
$table = $config['DATABASE_TABLE'];
$sql = "SELECT * FROM $table WHERE position_order = $page ";
$sections = $conn -> query($sql);
echo "<div class='content'>";
?>
<div id="navigation">
  <div class="mobile-nav">
       <div class="menu-btn" id="menu-btn">
  	<div></div>
  	<span></span>
  	<span></span>
  	<span></span>
       </div>

       <div class="responsive-menu">
          <ul>
             <li><a href="sorter.php">Sorter</a></li>
             <li><a href="editor.html">Editor</a></li>
          </ul>
       </div>
  </div>
</div>
<?php
while($section = $sections->fetch_assoc()){
  echo "<div id='header'>";
    echo "<div class='title'>";
      echo $section['header'];
        echo "<div class='page_num'>";
          echo "Page: $page";
          if( isset($section['date']) && $section['date'] != "0000-00-00" ) {
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
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
