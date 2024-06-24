<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
$id_order=$_GET['id_order'];
$query="delete from orders where id_order={$id_order}";
$result=$mysqli->query($query);
require_once("searchorder.php");
require_once("footer.php");
?>