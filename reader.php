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
require('conn.php');
$table = $config['DATABASE_TABLE'];
$sql = "SELECT * FROM $table WHERE position_order = $page ";
$sections = $conn -> query($sql);

echo "<html><head><title>Reader</title>";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="_css/layout.css" id="styleid" type="text/css" />
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
            if( e.which == 37 && <?php echo $page; ?> > 1 ) {
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

      if((end > start + offset) && <?php echo $page; ?> > 1){
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
  <div class="wrapper" >

    <header>
			<label><?php echo $title; ?></label>
		</header>
		<div id="content">
			<div id="navigation-container">
			<div id="navigation">
				<div class="mobile-nav">
						 <div class="menu-btn" id="menu-btn">
						 <div>
				</div>
					<span></span>
					<span></span>
					<span></span>
						 </div>

						 <div class="responsive-menu">
								<ul>
									<li><a href="editor.html">Editor</a></li>
									<li><a href="sorter.php">Sorter</a></li>
								</ul>
						 </div>
				</div>
			</div>
			<div id="page_num">
				Page: <?php echo $page;
        if( isset($section['date']) && $section['date'] != "0000-00-00" ) {
          $date = $section['date'];
          $date = date_create($date);
          $year = date_format($date,"Y");
          echo "<br />Year: $year";
        }
        ?>
      </div>
<?php
while($section = $sections->fetch_assoc()){
  $title = $section['header'];
  echo "<label class='header'>$title</label>";
  echo "<div id='page'>";
if( $section['image_url'] != "" ) {
  echo "<center>";
  $figures = explode(",",$section['image_url']);
  $num_figures = sizeof($figures);
  if( $num_figures == 1 ) {
      $pieces = explode(":", $figures[0]);
      $figure = $pieces[0];
      $width = "300px";
      $heigth = "400px";
      if( sizeof($pieces) > 1 ) {
          $width = $pieces[1];
          $heigth = $pieces[2];
      }
      $src = urlencode($figure);
      $image = "./figures/$src";
      $path_parts = pathinfo($image);
      $figure = $path_parts['filename'];
      echo "<img src=$image style=\"width:$width;height:$heigth;\" />";
      echo "<p />";
      echo "<header>$figure</header><p />";
    } else {
      $width = 800/$num_figures;
      $height = $width;
       ?>
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
          $image = "./figures/$src";
          $path_parts = pathinfo($image);
          $figure = $path_parts['filename'];
          ?> <td><header> <?php echo "$figure"; ?></header></td><?php
        } ?>
      </tr>
      </tbody>
      </table>
      <?php
}
echo "</center>";
}
echo $section['data'];

echo "</div>";
}



?>
</div>
<div class="nav-buttons">

<form action='' method='POST'>
  <?php
    if( $page > 1 ) { ?>
    <div class="nav-button"><input type='submit' name='submit' value='First'/></div>
    <div class="nav-button"><input type='submit' name='submit' value='Prev' /></div>
  <?php } ?>
    <div class="nav-button"><input type='submit' name='submit' value='Next'/></div>
</form>

</div>

<div id="footer">
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
</div>
</body>
</html>
