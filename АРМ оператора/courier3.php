<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
$id_courier=$_GET['id_courier'];
$query="update courier set flag='0' where id_courier={$id_courier}";
$result=$mysqli->query($query);
require_once("courier1.php");
require_once("footer.php");
?>