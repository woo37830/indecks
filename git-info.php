<?php
   require 'config.ini.php';
   $last = exec('git log -1 --date=format:"%Y/%m/%d" --format="%ad"');
   $rev = exec('git rev-parse --short HEAD');
   $branch = exec('git rev-parse --abbrev-ref HEAD');
   $dbase = $config['DATABASE_TABLE'];
   echo "<center>Last Update: $last &nbsp;&nbsp;Commit: $rev &nbsp;&nbsp;&nbsp;Branch: $branch &nbsp;&nbsp; Database: $dbase </center>";
?>
