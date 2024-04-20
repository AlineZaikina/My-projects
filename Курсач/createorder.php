<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['id_client']))
$id_client=$_GET['id_client'];
else $id_client=0;
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
<div class="stages">
    <a class="stage" href="neworder_checknumber.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span >Назначение</span></a>
    <a class="stage" href="editclient.php?id_client=<?php echo $id_client?>&timeofdelivery=<?=$timeofdelivery?>&id_order=<?=$id_order?>&id_operator=<?=$idoperator?>"><span>Доставка</span></a>
    <span class="stage" style="color: rgb(251, 244, 198);">Покупки</span>
    <a class="stage" href="confirmorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Подтверждение</span></a>
</div>
<form action="" method="post" class="content">
<?php
if ($id_client>0)
{   
    $query="select * from client where id_client={$id_client}";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
}
if ($id_order>0)
{
    $query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_order={$id_order} and o.id_client=cl.id_client and o.id_courier=co.id_courier 
    and o.id_operator=op.id_operator and o.id_time=t.id_time";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
    echo '<div class="corzina">Заказ от <span><input value="'.$row['date'].'" class="hidendatetime" readonly="true" name="date"></span>';  
    echo '<span><input value="'.$row['time_order'].'" class="hidendatetime" readonly="true" name="time"></span></div>';
}
else
{
    echo '<div class="corzina">Заказ от <span><input id = "date" class="hidendatetime" readonly="true" name="date"></span>';  
    echo '<span><input id="time" class="hidendatetime" readonly="true" name="time"></span></div>'; 
}
?>
<p><span class="corzina">Клиент: </span> 
<?php 
if ($id_client>0 || $id_order>0)
    echo $row['number'].','.$row['fio_client'].','.$row['street'].','.$row['house'];
    if (!empty($row['flat'])) echo ', кв '.$row['flat']; 
    if (!empty($row['entrance'])) echo ', подъезд '.$row['entrance'];
    if (!empty($row['floor'])) echo ', этаж '.$row['floor'];
else echo "";?></p>
<table>
<tr>
<td class="corzina">Курьер:  <select class="co" name = "couriers">
<?php
if ($id_order>0)
{
    $query1="select * from courier where flag=1";
    $result1=$mysqli->query($query1);
	while($row1=$result1->fetch_array())
    {
        if($row1['id_courier']==$row['id_courier'])
        echo "<option value=".$row1['id_courier']." selected>".$row1['fio_courier']."</option>";
        else
        echo "<option value=".$row1['id_courier'].">".$row1['fio_courier']."</option>";
    }	
}
if ($id_order==0)
{
    $query1="select * from courier where flag=1";
    $result1=$mysqli->query($query1);
	while($row1=$result1->fetch_array())
	echo "<option value=".$row1['id_courier'].">".$row1['fio_courier']."</option>";
}
?>
</select>
</td>
</tr>
</table>
<div class="content1">
<div class="t1"><table class="menu" border=1>
<?php
for ($j=1;$j<=3;$j++) 
{
    $query="select * from sizeofpizza where id_size={$j}";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
    if ($j==1)
    {
        $koefbig = $row['koef_of_size'];
    }
    if ($j==2)
    {
        $koefmiddle = $row['koef_of_size'];
    }
    if ($j==3)
    {
        $koeflittle = $row['koef_of_size'];
    }
} 
$query="select * from pizza where id_size=3 and flag=1";
$result=$mysqli->query($query);
$i=0;
while ($row=$result->fetch_assoc())
{
    if ($i==0)
    {
        echo"<tr>";
        $i=1;
    }
    if ($i==1 || $i==2 || $i==3)
    {
        echo '<td><span>'.$row['name_of_pizza'].'</span>';
        for($j=1;$j<=3;$j++)
        {
            $query1="select price_standart from pizza where id_size={$j} and name_of_pizza='{$row['name_of_pizza']}'";
            $result1=$mysqli->query($query1);
            $row1=$result1->fetch_assoc();
            if ($j==1)
            {
                $price_big=$row1['price_standart'];
            }
            if ($j==2)
            {
                $price_middle=$row1['price_standart'];
            }
            if ($j==3)
            {
                $price_little=$row1['price_standart'];
            }
        }
        echo "<p>";
        echo '<input type="button" class="btn3" value="Большая" name="1-'.$koefbig.'" id="'.$row['name_of_pizza'].'-'.$price_big.'" onclick="CatchButton(this);"><input type="button" class="btn3" value="Средняя" name="2-'.$koefmiddle.'" id="'.$row['name_of_pizza'].'-'.$price_middle.'" onclick="CatchButton(this);"><input type="button" class="btn3" value="Маленькая" name="3-'.$koeflittle.'" id="'.$row['name_of_pizza'].'-'.$price_little.'" onclick="CatchButton(this);">';
        echo "</p>";
        echo "</td>";
        $i=$i+1;
    }
    if ($i>3)
    {
        echo "</tr>";
        $i=0;
    }
}
echo "</table>";
echo "</div>";
?>  
<div class="t2">
<div class="corzina corzina__header">Корзина</div>
<table border=1 id="t1" class="corzinatable">
    <tr>
        <td style="padding: 5px 0;">№</td>
        <td style="padding: 5px 0;">Название</td>
        <td style="padding: 5px 0;">Размер</td>
        <td style="padding: 5px 0;">Количество</td>
        <td style="padding: 5px 0;">Цена</td>
        <td style="padding: 5px 0;">Стоимость</td>
        <td style="padding: 5px 0;" name="del">Удаление</td>
    </tr>
<?php
if ($id_order>0)
{
    $query="select * from pizza p, sizeofpizza s, ordercomposition o where o.id_order={$id_order} and o.id_pizza=p.id_pizza and p.id_size=s.id_size";
    $result=$mysqli->query($query);
    $i=1;
    while ($row=$result->fetch_assoc())
    {
        echo "<tr>";
        echo '<td><input value="'.$i.'" class="tabletext" readonly="true" style="width: 25px;"></td>';
        echo '<td><input name="pizza'.$i.'" value="'.$row['name_of_pizza'].'" class="tabletext" readonly="true" style="width: 105px;"></td>';
        echo '<td><input name="size'.$i.'" value="'.$row['name_of_size'].'" class="tabletext" readonly="true" style="width: 100px;"></td>';
        echo '<td><input name="quantity'.$i.'" value="'.$row['quantity'].'" class="tabletext" readonly="true" style="width: 90px;">';
        echo '<td><input value="'.$row['price_standart'] * $row['koef_of_size'].'" readonly="true" class="tabletext" style="width: 40px;"></td>';
        echo '<td><input value="'.$row['price_standart'] * $row['koef_of_size'] * $row['quantity'].'" readonly="true" class="tabletext" style="width: 80px;"></td>';
        echo '<td><input type="button" id='.$i.' value="Удалить" style="width: 75px;" class="btn3" onclick="DeleteStr(this);"></td>';
        echo "</tr>";
        $i=$i+1;
    }
}
?>
</table>
<br>
<div class="corzina corzina__header">Оплата</div>
<div class="checkbox">
    <?php
    if ($id_order>0)
    {
        $query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_order={$id_order} and o.id_client=cl.id_client and o.id_courier=co.id_courier 
        and o.id_operator=op.id_operator and o.id_time=t.id_time";
        $result=$mysqli->query($query);
        $row=$result->fetch_assoc();
        if ($row['type_of_pay'] == 1)
        {
            echo '<input type="checkbox" id="checkbox" name="checkbox" checked>Оплата онлайн';
        }
        else
        {
            echo '<input type="checkbox" id="checkbox" name="checkbox">Оплата онлайн';
        }
    }
    else
    {
        echo '<input type="checkbox" id="checkbox" name="checkbox">Оплата онлайн';
    }
    ?>
    <br>
    <input type="number" id="kupura" placeholder="С какой суммы сдача" class="cupura_sdachi" onkeyup="CountSumSdachi()">
    <span>Сумма сдачи:  </span><input id="summasdachi" name="summasdachi" class="hidendatetime" style="font-size: 12pt;"></input>
    <br>
    <?php
    if ($id_order>0)
    {
        $query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_order={$id_order} and o.id_client=cl.id_client and o.id_courier=co.id_courier 
        and o.id_operator=op.id_operator and o.id_time=t.id_time";
        $result=$mysqli->query($query);
        $row=$result->fetch_assoc();
        echo '<input type="text" value="'.$row['comment_for_order'].'" style="width: 90%;" placeholder="Комментарий к заказу" id="comment" name="comment" class="cupura_sdachi">';
    }
    else
    {
        echo '<input type="text" style="width: 90%;" placeholder="Комментарий к заказу" id="comment" name="comment" class="cupura_sdachi">';
    }
    ?>
</div>
<?php
if ($id_order>0)
{
    $query="select * from orders o, client cl, courier co, operator op, timeofdelivery t where o.id_order={$id_order} and o.id_client=cl.id_client and o.id_courier=co.id_courier 
    and o.id_operator=op.id_operator and o.id_time=t.id_time";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
    echo '<p class="corzina">Сумма заказа: <span><input class="hidendatetime" value="'.$row['cost_of_order'].'" id="itogo" name="itogo"></span></p>';

}
else
{
    echo '<p class="corzina">Сумма заказа: <span><input class="hidendatetime" id="itogo" name="itogo"></span></p>';
}
?>
<p><input type="submit" value="Далее" name="btnContinue" class="btn1" ></p>
<?php

if (isset($_POST['btnContinue']))
{
    if ($id_client>0 && $id_order==0)
    {
        if(isset($_POST['pizza1']))
        {
            $date=$mysqli->real_escape_string($_POST['date']);
            $time=$mysqli->real_escape_string($_POST['time']);
            $timeoforder=$mysqli->real_escape_string($timeofdelivery);
            $client=$mysqli->real_escape_string($id_client);
            $courier=$mysqli->real_escape_string($_POST['couriers']);
            if (isset($_POST["checkbox"])) $typeofpay = 1;
            else $typeofpay = 0;
            $comment=$mysqli->real_escape_string($_POST['comment']);
            $itogo=$mysqli->real_escape_string($_POST['itogo']);
            $query="insert into orders values('','{$date}','{$time}','{$timeoforder}','{$client}','{$idoperator}','{$courier}','{$typeofpay}','{$comment}','{$itogo}')";
            $result=$mysqli->query($query);
            $query = "select id_order from orders ORDER BY id_order DESC LIMIT 1";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            $idorder=$row['id_order'];
            $i=1;
            while (isset($_POST["pizza$i"]))
            {
                $pizza=$_POST["pizza$i"];
                $size=$_POST["size$i"];
                $query1 = "select id_pizza from pizza p, sizeofpizza s where p.id_size=s.id_size and name_of_pizza='{$pizza}' and name_of_size='{$size}'";
                $result1=$mysqli->query($query1);
                $row1=$result1->fetch_assoc();
                $id_pizza=$mysqli->real_escape_string($row1['id_pizza']);
                $quantity=$mysqli->real_escape_string($_POST["quantity$i"]);
                $query="insert into ordercomposition values('{$idorder}','{$id_pizza}','{$quantity}')";
                $result=$mysqli->query($query);
                $i=$i+1;
            }
            if ($mysqli->affected_rows>0)
            $mysqli->close();
            $content = 
            "<script>
                window.location.href='http://localhost/Курсач/confirmorder.php?id_order=$idorder&timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
        else
        {
            echo "<p class=\"sign2\" style=\"width: 110px;\">Заполните заказ!</p>";
        }
    }
    else
    {
        echo "<p class=\"sign2\" style=\"width: 380px;\">Для создания заказа необходимо зарегестрировать клиента!</p>";
    }
    if ($id_order>0)
    {
        if(isset($_POST['pizza1']))
        {
            $date=$mysqli->real_escape_string($_POST['date']);
            $time=$mysqli->real_escape_string($_POST['time']);
            $timeoforder=$mysqli->real_escape_string($timeofdelivery);
            $client=$mysqli->real_escape_string($row['id_client']);
            $courier=$mysqli->real_escape_string($_POST['couriers']);
            if (isset($_POST["checkbox"])) $typeofpay = 1;
            else $typeofpay = 0;
            $comment=$mysqli->real_escape_string($_POST['comment']);
            $itogo=$mysqli->real_escape_string($_POST['itogo']);
            $query="update orders set date='{$date}', time_order='{$time}', id_time='{$timeofdelivery}', id_client='{$client}', id_operator='{$idoperator}', id_courier='{$courier}', type_of_pay='{$typeofpay}', comment_for_order='{$comment}', cost_of_order='{$itogo}' where id_order={$id_order}";
            $result=$mysqli->query($query);
            $query="delete from ordercomposition where id_order={$id_order}";
            $result=$mysqli->query($query);
            $i=1;
            while (isset($_POST["pizza$i"]))
            {
                $pizza=$_POST["pizza$i"];
                $size=$_POST["size$i"];
                $query1 = "select id_pizza from pizza p, sizeofpizza s where p.id_size=s.id_size and name_of_pizza='{$pizza}' and name_of_size='{$size}'";
                $result1=$mysqli->query($query1);
                $row1=$result1->fetch_assoc();
                $id_pizza=$mysqli->real_escape_string($row1['id_pizza']);
                $quantity=$mysqli->real_escape_string($_POST["quantity$i"]);
                $query="insert into ordercomposition values('{$id_order}','{$id_pizza}','{$quantity}')";
                $result=$mysqli->query($query);
                $i=$i+1;
            }
            if ($mysqli->affected_rows>0)
            $mysqli->close();
            $content = 
            "<script>
                window.location.href='http://localhost/Курсач/confirmorder.php?id_order=$id_order&timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
    }
} 
?>
</div>
</div>
</form>
<?php
require_once("footer.php");
?>
<script>
    window.onload = GetTime;
    document.onclick = DisableSdacha;
</script>