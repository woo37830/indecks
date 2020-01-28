<?php
require 'config.ini.php';

$conn = new mysqli($config['DATABASE_SERVER'],$config['DATABASE_USER'],$config['DATABASE_PASSWORD'],$config['DATABASE']);

?>
