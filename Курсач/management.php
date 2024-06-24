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
<form action="" method="post" class="content2" style="margin: 0 auto; text-align: center;">
<p class="corzina">Время доставки:    <select class="co" name = "timeofdelivery"></p>
<?php
$query="select * from timeofdelivery";
$result=$mysqli->query($query);
while($row=$result->fetch_array())
{
    if ($row['id_time']==$timeofdelivery)
    echo "<option value=".$row['id_time']." selected>".$row['time']."</option>";
    else
    echo "<option value=".$row['id_time'].">".$row['time']."</option>";
}
?> 
</select>
<input type="submit" class="btn1" name="btnSave" value="Сохранить" style="margin-left: 15px;">
<?php
if (isset($_POST['btnSave']))
{
    $time = $_POST['timeofdelivery'];
    $content = 
        "<script>
            window.location.href='http://localhost/Курсач/management.php?timeofdelivery=$time&id_operator=$idoperator';
        </script>";
    echo $content;
}
?>
<br>
<a class="link2" href="courier1.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>1. Список курьеров</span></a>
<br>
<a class="link2" href="operator1.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>2. Список операторов</span></a>
<br>
<a class="link2" href="pizza1.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>3. Меню</span></a>
<br>
<a class="link2" href="koef1.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>4. Коэффициенты ценообразования</span></a>
</form>
<?php
require_once("footer.php");
?>