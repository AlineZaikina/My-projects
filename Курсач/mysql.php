<?php
require_once 'inc.php'; 
$mysqli = new mysqli($host, $user, $password, $db);
/*if ($mysqli->connect_errno) 
echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
else
	echo "Mysql ok";*/
$mysqli->set_charset("utf8")
?>