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
                        <td><a class="link1" href="searchorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Поиск <br>заказа</a></td>
                        <td><a class="link1" style="color: rgb(251, 244, 198);" href="management.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Управление <br>точкой</a></td>
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
<h1>Действующие операторы</h1>
<input type = "text" name="tx" id="tx" autocomplete="off" placeholder="Поиск..." class="textforcreateedit textforworkers search" onkeyup="Search()">
<table class="couriertable" border=1 id="ta">
<tr>
    <td style="font-weight: bold;">№</td>
    <td style="font-weight: bold;">ФИО оператора</td>
    <td style="font-weight: bold;">Редактирование</td>
    <td style="font-weight: bold;">Удаление</td>
</tr>
<?php
$query="select * from operator where flag=1";
$result=$mysqli->query($query);
$i=1;
while ($row=$result->fetch_assoc())
{
    $id_operator=$row['id_operator'];
    echo '<tr>';
    echo '<td><input value="'.$i.'" class="tabletext" readonly="true" style="width: 25px;"></td>';
    echo '<td><input value="'.$row['fio_operator'].'" class="tabletext" readonly="true" style="width: 150px;"></td>';
    echo '<td><a href="operator2.php?id_operator_select='.$id_operator.'&timeofdelivery='.$timeofdelivery.'&id_operator='.$idoperator.'" style="width: 120px;font-size: 10pt;" class="btn3 btn4">Редактировать</a></td>';
    echo '<td><a href="operator3.php?ido_perator_select='.$id_operator.'&timeofdelivery='.$timeofdelivery.'&id_operator='.$idoperator.'" style="width: 120px;font-size: 10pt;" class="btn3 btn4">Удалить</a></td>';
    echo '</tr>';
    $i=$i+1;
}
?>
</table>
<input type="submit" value="+" id="addstr" name="addstr" class="btn3 addstr">
<?php
if (isset($_POST['addstr']))
{
    $content=
    "<script>
        window.location.href='http://localhost/Курсач/operator2.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
    </script>";
    echo $content;
}
?>
</form>
<?php
require_once("footer.php");
?>