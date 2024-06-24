<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['id_order']))
$id_order=$_GET['id_order'];
else $id_order=0;
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
                        <td><a class="link1" href="management.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Управление <br>точкой</a></td>
                        <td><a class="link1" href="createreport.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Отчетная <br>документация</a></td>
                        <td class="operator-title"><?php echo $row1['fio_operator']; ?></td>
                        <td><a href="register.php"><img src="img/entrance.svg" class="entrance"></a></td>
                    </tr>
                </table>
                <table class="timeofdelivery">
                    <tr>
                        <td> Время доставки</td>
                        <td class="time"><?php echo $row['time']?></td>
                    </tr>
                </table>
            </div>
<?php
if ($id_order>0)
{
    $query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_order={$id_order} and o.id_client=cl.id_client and o.id_courier=co.id_courier 
    and o.id_operator=op.id_operator and o.id_time=t.id_time";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
}
?>
<div class="stages">
    <a class="stage" href="neworder_checknumber.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span >Назначение</span></a>
    <a class="stage" href="editclient.php?id_order=<?=$id_order?>&timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Доставка</span></a>
    <a class="stage" href="createorder.php?id_order=<?=$id_order?>&timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Покупки</span></a>
    <span class="stage" style="color: rgb(251, 244, 198);">Подтверждение</span>
</div>
<form action="" method="post" class="content">
    <a href="orderdoc.php?id_order=<?=$id_order?>&rej=2&id_operator=<?=$idoperator?>&timeofdelivery=<?=$timeofdelivery?>" class="btn41">Показать документ</a>
    <div class="corzina" style="text-decoration: underline;">Заказ от <span><?php if ($id_order>0) echo $row['date']; else echo "";?> 
    <?php if ($id_order>0) echo $row['time_order']; else echo "";?><span></div>
    <p class="confirm"><span class="words">Клиент: </span><span><?php if ($id_order>0) echo $row['fio_client']; else echo "";?><span></p>
    <p class="confirm"><span class="words">Номер клиента: </span><span><?php if ($id_order>0) echo $row['number']; else echo "";?><span></p>
    <p class="confirm"><span class="words">Адрес клиента: </span><span>
        <?php 
        if ($id_order>0) 
        {
            echo $row['street'].','.$row['house'];
            if (!empty($row['flat'])) echo ', кв '.$row['flat']; 
            if (!empty($row['entrance'])) echo ', подъезд '.$row['entrance'];
            if (!empty($row['floor'])) echo ', этаж '.$row['floor'];
        else echo "";
        }
        ?><span></p>
    <p class="confirm"><span class="words">Курьер: </span><span><?php if ($id_order>0) echo $row['fio_courier']; else echo "";?><span></p>
    <p class="confirm"><span class="words">Оплата: </span>
    <span>
        <?php 
        if ($id_order>0) 
        {
            if ($row['type_of_pay'] == 1) echo "Оплачен онлайн";
            else echo "Оплата наличными";
        }
        else echo "";?>
    <span></p>
    <p class="confirm"><span class="words">Комментарий к заказу: </span><span><?php if ($id_order>0) echo $row['comment_for_order']; else echo "";?><span></p>    
    <p class="confirm" style="text-align: center;"><span class="words">Корзина</span>
    <br>
    <p></p><table border=1 align="center" class="t3";>
    <tr>
        <td class="bold">№</td>
        <td class="bold">Название</td>
        <td class="bold">Размер</td>
        <td class="bold">Количество</td>
        <td class="bold">Цена</td>
        <td class="bold">Стоимость</td>
    </tr>
    <?php
    if ($id_order>0)
    {
        $query1="select * from pizza p, sizeofpizza s, ordercomposition o where o.id_order={$id_order} and o.id_pizza=p.id_pizza and p.id_size=s.id_size";
        $result1=$mysqli->query($query1);
        $i=1;
        while ($row1=$result1->fetch_assoc())
        {
            echo "<tr>";
            echo '<td>'.$i.'</td>';
            echo "<td>".$row1['name_of_pizza']."</td>";
            echo "<td>".$row1['name_of_size']."</td>";
            echo "<td>".$row1['quantity']."</td>";
            echo "<td>".$row1['price_standart'] * $row1['koef_of_size']."</td>";
            echo "<td>".$row1['price_standart'] * $row1['koef_of_size'] * $row1['quantity']."</td>";
            echo "</tr>";
            $i=$i+1;
        }
    }
    ?>
    </table>
    <p class="confirm" style="margin-left: 1150px;"><span style="font-weight: bold" class="words">Итого: </span><span><?php if ($id_order>0) echo $row['cost_of_order']; else echo "";?><span></p>
    <p><a href="searchorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>" class="btn4">Назад</a></p>
</form>
<?php
require_once("footer.php");
?>
