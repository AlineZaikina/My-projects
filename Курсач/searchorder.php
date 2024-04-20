<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['timeofdelivery']))
{
    $timeofdelivery = $_GET['timeofdelivery'];
}
else
{
    $timeofdelivery = 1;
}
$idoperator = $_GET['id_operator'];
$query="select * from timeofdelivery where id_time={$timeofdelivery}";
$result=$mysqli->query($query);
$row=$result->fetch_assoc();
$query1="select fio_operator from operator where id_operator={$idoperator}";
$result1=$mysqli->query($query1);
$row1=$result1->fetch_assoc();
?>
<body class="container">
        <img src = "img/logo.png" width="160" height="150" class="black"/>
            <div class="black">
                <table class="menu">
                    <tr>
                        <td><a class="link1" href="neworder_checknumber.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Новый <br>заказ</a></td>
                        <td><a class="link1" style="color: rgb(251, 244, 198);" href="searchorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Поиск <br>заказа</a></td>
                        <td><a class="link1" href="management.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Управление <br>точкой</a></td>
                        <td><a class="link1" href="createreport.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Отчетная <br>документация</a></td>
                        <td class="operator-title"><?php echo $row1['fio_operator']; ?></td>
                        <td><a href="register.php"><img src="img/entrance.svg" class="entrance"></a></td>
                    </tr>
                </table>
                <table class="timeofdelivery">
                    <tr>
                        <td> Время доставки</td>
                        <td class="time" id="time"><?php echo $row['time']?></td>
                    </tr>
                </table>
            </div>
<form action="" method="post" class="content2">
<h1>Поиск заказа</h1>
<input type = "text" name="tx" id="tx" autocomplete="off" placeholder="Поиск..." class="textforcreateedit textforworkers search" onkeyup="Search()">
<table class="searchtable" border=1 id="ta">
<tr>
    <td style="font-weight: bold;">№</td>
    <td style="font-weight: bold;">№ заказа</td>
    <td style="font-weight: bold;">Дата заказа</td>
    <td style="font-weight: bold;">Время заказа</td>
    <td style="font-weight: bold;">Время доставки</td>
    <td style="font-weight: bold;">Номер клиента</td>
    <td style="font-weight: bold;">Имя клиента</td>
    <td style="font-weight: bold;">Адрес доставки</td>
    <td style="font-weight: bold;">Имя оператора</td>
    <td style="font-weight: bold;">Имя курьера</td>
    <td style="font-weight: bold;">Стоимость</td>
    <td style="font-weight: bold;">Подробнее</td>
    <td style="font-weight: bold;">Удаление</td>
</tr>
<?php
$query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_client=cl.id_client and o.id_courier=co.id_courier 
and o.id_operator=op.id_operator and o.id_time=t.id_time order by id_order desc";
$result=$mysqli->query($query);
$i=1;
while ($row=$result->fetch_assoc())
{
    $id_order=$row['id_order'];
    echo '<tr>';
    echo '<td>'.$i.'</td>';
    echo '<td>'.$id_order.'</td>';
    echo '<td>'.$row['date'].'</td>';
    echo '<td>'.$row['time_order'].'</td>';
    echo '<td>'.$row['time'].'</td>';
    echo '<td>'.$row['number'].'</td>';
    echo '<td>'.$row['fio_client'].'</td>';
    echo '<td>'.$row['street'].','.$row['house'];
    if (!empty($row['flat'])) echo ', кв '.$row['flat']; 
    if (!empty($row['entrance'])) echo ', подъезд '.$row['entrance'];
    if (!empty($row['floor'])) echo ', этаж '.$row['floor'];
    echo '</td>';
    echo '<td>'.$row['fio_operator'].'</td>';
    echo '<td>'.$row['fio_courier'].'</td>';
    echo '<td>'.$row['cost_of_order'].'</td>';
    echo '<td><a href="confirmorder2.php?id_order='.$id_order.'&timeofdelivery='.$timeofdelivery.'&id_operator='.$idoperator.'" style="width: 120px;font-size: 10pt;" class="btn3 btn4">Подробнее</a></td>';
    echo '<td><a href="searchorder2.php?id_order='.$id_order.'&timeofdelivery='.$timeofdelivery.'&id_operator='.$idoperator.'" style="width: 120px;font-size: 10pt;" class="btn3 btn4">Удалить</a></td>';
    echo '</tr>';
    $i=$i+1;
}
?>
</table>
</form>
<?php
require_once("footer.php");
?>