<?php
   $rev = exec('git rev-parse --short HEAD');
   $branch = exec('git rev-parse --abbrev-ref HEAD');
   echo "<center>Commit: $rev &nbsp;&nbsp;&nbsp;Branch: $branch </center>";
?>
