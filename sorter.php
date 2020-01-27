<!DOCTYPE html>
<html>
<head>
    <title>Sorter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./_js/jquery.easyui.min.js"></script>
  	<link rel="stylesheet" href="_css/home.css" id="styleid" type="text/css" />
    <LINK REL="stylesheet" HREF="_css/menu.css" id="styleid"/>
  	<link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">
    <script type="text/javascript">
		  jQuery(function($){
		           $( '.menu-btn' ).click(function(){
		           $('.responsive-menu').toggleClass('expand')
		           })
		        })
		</script>
</head>
<body>
    <div class="content">
      <br />
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
                   <li><a href="reader.php">Reader</a></li>
                   <li><a href="editor.html">Editor</a></li>
                </ul>
             </div>
        </div>
      </div>
      <div id="page" >

      <div id="log_in">Login</div>
    <div class="title">
        Biographical Event Sorter
      </div>
       <div id="data">
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Section</th>
                <th>Text</th>
                <th>Date</th>
            </tr>
            <tbody class="row_position">
            <?php

            require('conn.php');
            $sql = "SELECT * FROM books ORDER BY position_order";
            $sections = $conn -> query($sql);
            while($section = $sections->fetch_assoc()){
                $date = $section['date'];
                $year = "";
                if( $date != null ) {
                  $date_time = date_create($date);
                  $year = date_format($date_time,'Y');
                }
            ?>
                <tr  id="<?php echo $section['id'] ?>">
                    <td><?php echo $section['id'] ?></td>
                    <td><?php echo $section['header'] ?></td>
                    <td><?php echo $section['data'] ?></td>
                    <td><?php echo $year ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
      </div>
      <div id="no-access">
        <h3>You must be logged in to use the sorter</h3>
      </div>
    </div>
  </div>
    <div id="footer" >
  	  <em><?php
  	  include 'git-info.php';
  	  ?></em>
  	</div>
  	<div id="lin" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px"
  			closed="true" buttons="#lin-buttons">
  		<div class="ftitle">Login</div>
  		<form id="lfm" method="post" novalidate>
  			<div class="fitem">
  				<label>User:</label>
  				<input name="user" class="easyui-textbox" id="userid" required="true">
  			</div>
  			<div class="fitem">
  				<label>Password:</label>
  				<input name="passwd" type= "password" class="easyui-textbox" id="password" required="true">
  			</div>
  		</form>
  	</div>
    <div id="lin-buttons">
      <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="authorize()" style="width:90px">Login</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#lin').dialog('close')" style="width:90px">Cancel</a>
    </div>

<!-- container / end -->
</body>

<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });

            updateOrder(selectedData);
        }
    });

    function updateOrder(data) {
        $.ajax({
            url:"ajaxPro.php",
            type:'post',
            data:{position:data},
            success:function(){
                alert('your change successfully saved');
            }
        })
    }
    $(document).on('click','#log_in', function() {
    $.getJSON( "./users.txt", function( json ) {
         $.each(json, function( key, value) {
         //for( var i=0; i<value.length; i++ ) {
        //alert("user = "+value[i].user+" password = "+value[i].passwd);
        //}
        users = $.map(value, function(el) { return el });
  });
});
        login();
    });
    $(document).on('click','#log_out', function() {
        logout();
    });

            if( readCookie("logged_in") ) {
          	                $("#log_in").text("Logout: "+readCookie('userid'));
          	                $("#log_in").attr('id', 'log_out');
                              $("#data").attr('class', 'show');
                              $("#no-access").attr('class','hide');
                              $("#lin").attr('class','hide');
                              $("#lin-buttons").attr('class','hide');
          	} else {
          	            $("#log_out").text("Login");
          	            $("#log_out").attr('id', 'log_in');
                          $("#data").attr('class', 'hide');
                          $("no-access").attr('class','show');
        	}
                   var days = 1;
              	function login() {
          	                $('#lin').dialog('open').dialog('set Title', 'Login');
          	                $('#lfm').form('clear');
          	        }
          	    function logout() {
          	            eraseCookie('logged_in');
          	            eraseCookie('userid');
          	            window.location.reload();
          	        }
          	    function authorize() {
          	        // Compare the form data to the json data and if match, createCookie, else logout;
          	        // alert("json data: " + json.user[1] + ", " + json.passwd);
          	        //alert("form data: " + document.getElementById("userid").value);
          	        uName = document.getElementById("userid").value;
          	        var pName = document.getElementById("password").value;
          	       $('#lin').dialog('close');
          	       var done = false;
          	 	   for( var i=0;i<users.length&&!done;i++) {
          	 	       // alert("Testing '"+users[i].user+"' and '"+users[i].passwd+"'");
          	            if( uName == users[i].user && pName == users[i].passwd ) {
                            createCookie('logged_in', 'yes', days);
          	                createCookie('userid', uName);
          	                user = uName;
          	                done = true;
          	            }
          	        }
          	        if( !done ) {
          	                alert('username or password not found');
          	                logout();
          	        } else {
          	           // alert("Cookie: 'logged_in': "+readCookie('logged_in'));
          	            }
          	            window.location.reload();
          	        }
                    // Cookie functions
                  function createCookie(name,value,days) {
                  	if (days) {
                  		var date = new Date();
                  		date.setTime(date.getTime()+(days*24*60*60*1000));
                  		var expires = "; expires="+date.toGMTString();
                  	}
                  	else var expires = "";
                  	document.cookie = name+"="+value+expires+"; path=/";
                  }

                  function readCookie(name) {
                  	var nameEQ = name + "=";
                  	var ca = document.cookie.split(';');
                  	for(var i=0;i < ca.length;i++) {
                  		var c = ca[i];
                  		while (c.charAt(0)==' ') c = c.substring(1,c.length);
                  		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                  	}
                  	return null;
                  }

                  function eraseCookie(name) {
                  	createCookie(name,"",-1);
                  	//alert("Cookie: "+name+": "+readCookie(name));
                      }
                    var logged_in = document.getElementById('logged_in');
                    if (readCookie('logged_in') ) {
                        createCookie('logged_in', 'yes', days);
                    } else {
                        toolbar.className = 'hide';
                    }
</script>
<style type="text/css">

        #dlg-buttons div {
            float: left;
            clear: none;
        }
  #fm{
    margin:0;
    padding:10px 30px;
    }
  .ftitle{
    font-size:14px;
    font-weight:bold;
    padding:5px 0;
    margin-bottom:10px;
    border-bottom:1px solid #ccc;
  }
  .fitem{
    margin-bottom:5px;
  }
  .fitem label{
    display:inline-block;
    width:80px;
  }
  .fitem input{
    width:360px;
  }
  .datatable td {
            overflow: hidden; /* this is what fixes the expansion */
            text-overflow: ellipsis; /* not supported in all browsers, but I accepted the tradeoff */
            white-space: nowrap;
      }
      table.tablesorter { /* So it won't keep expanding */
          table-layout: fixed
      }
</style>
</html>
