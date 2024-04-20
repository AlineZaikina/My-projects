<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
$id_operator=$_GET['id_operator'];
$query="update operator set flag='0' where id_operator={$id_operator}";
$result=$mysqli->query($query);
require_once("courier1.php");
require_once("footer.php");
?>