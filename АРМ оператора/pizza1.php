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
<h1>Пиццы и их себестоимость</h1>
<table class="couriertable" style="width: 500px;" border=1 id="ta">
<?php
$query="select * from pizza where flag=1 and id_size=3";
$result=$mysqli->query($query);
while ($row=$result->fetch_assoc())
{
    echo '<tr>';
    echo '<td colspan=3><a class="pizzalink" href="pizza2.php?name_of_pizza='.$row['name_of_pizza'].'&timeofdelivery='.$timeofdelivery.'&id_operator='.$idoperator.'">'.$row['name_of_pizza'].'</a></td>';
    echo '</tr>';
    echo '<tr>';
    $query1="select * from pizza where name_of_pizza=\"{$row['name_of_pizza']}\"";
    $result1=$mysqli->query($query1);
    while ($row1=$result1->fetch_assoc())
    {
        echo '<td><input value="'.$row1['price_standart'].'" class="tabletext" readonly="true" style="width: 50px;text-align: center;"></td>';
    }
    echo '</tr>';
}
?>
</table>
<input type="submit" value="+" id="addstr" name="addstr" class="btn3 addstr">
<?php
if (isset($_POST['addstr']))
{
    $content=
    "<script>
        window.location.href='http://localhost/Курсач/pizza2.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
    </script>";
    echo $content;
}
?>
</form>
<?php
require_once("footer.php");
?>