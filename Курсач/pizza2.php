<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['name_of_pizza']))
$name_of_pizza=$_GET['name_of_pizza'];
else $name_of_pizza=0;
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
<h1>Создание/Редактирование меню</h1>
<table style="margin: auto; margin-top: 50px; border-spacing: 20px 30px;">
    <tr>
        <td>Введите название пиццы: </td>
        <td><input type = "text" value="<?php if ($name_of_pizza!=0) echo $name_of_pizza; else echo "";?>" name="txt1" id="txt1" autocomplete="off" class="textforcreateedit textforworkers"></td>
    </tr>
<?php
if ($name_of_pizza!=0)
{
    $query="select * from pizza where name_of_pizza=\"{$name_of_pizza}\"";
    $result=$mysqli->query($query);
    while($row=$result->fetch_assoc())
    {
        if($row['id_size']==3)
        {
            echo "<tr>";
            echo "<td>Цена за маленькую: </td>";
            echo '<td><input type = "number" value="'.$row['price_standart'].'" name="txt2" autocomplete="off" class="textforcreateedit textforworkers"></td>';
            echo "</tr>";
        }
        if($row['id_size']==2)
        {
            echo "<tr>";
            echo "<td>Цена за среднюю: </td>";
            echo '<td><input type = "number" value="'.$row['price_standart'].'" name="txt3" autocomplete="off" class="textforcreateedit textforworkers"></td>';
            echo "</tr>";
        }
        if($row['id_size']==1)
        {
            echo "<tr>";
            echo "<td>Цена за большую: </td>";
            echo '<td><input type = "number" value="'.$row['price_standart'].'" name="txt4" autocomplete="off" class="textforcreateedit textforworkers"></td>';
            echo "</tr>";
        }
    }
}
if ($name_of_pizza==0)
{
    echo "<tr>";
    echo "<td>Цена за маленькую: </td>";
    echo '<td><input type = "number" value="" name="txt2" autocomplete="off" class="textforcreateedit textforworkers"></td>';
    echo "</tr>";
    echo "<tr>";
    echo "<td>Цена за среднюю: </td>";
    echo '<td><input type = "number" value="" name="txt3" autocomplete="off" class="textforcreateedit textforworkers"></td>';
    echo "</tr>";
    echo "<tr>";
    echo "<td>Цена за большую: </td>";
    echo '<td><input type = "number" value="" name="txt4" autocomplete="off" class="textforcreateedit textforworkers"></td>';
    echo "</tr>";
}
?>
</table>
<table style="margin: auto; border-spacing: 300px 0px;">
    <tr>
        <td><input type="submit" value="Сохранить" name="btnSave" class="btn3 save"></td>
        <?php
        if ($name_of_pizza!=0)
            {echo '<td><input type="submit" style="width: 90px;" value="Удалить" name="btnDel" class="btn3 save"></td>';}
        echo "</tr>"
        ?>
</table>
<?php
if (isset($_POST['btnSave']))
{
    if ($name_of_pizza==0)
    {
        if (!empty($_POST['txt1']) && !empty($_POST['txt2']) && !empty($_POST['txt3']) && !empty($_POST['txt4']))
        {
            for($i=3;$i>0;$i--)
            {
                if($i==3)
                {
                    $price=$_POST['txt2'];
                    $pizza=$_POST['txt1'];
                    $query="insert into pizza values('','{$pizza}','{$price}','$i','1')";
                    $result=$mysqli->query($query);
                }
                if($i==2)
                {
                    $price=$_POST['txt3'];
                    $pizza=$_POST['txt1'];
                    $query="insert into pizza values('','{$pizza}','{$price}','$i','1')";
                    $result=$mysqli->query($query);
                }
                if($i==1)
                {
                    $price=$_POST['txt4'];
                    $pizza=$_POST['txt1'];
                    $query="insert into pizza values('','{$pizza}','{$price}','$i','1')";
                    $result=$mysqli->query($query);
                }
            }
            $content=
            "<script>
                window.location.href='http://localhost/Курсач/pizza1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
        else echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
    }
    if ($name_of_pizza!=0)
    {
        if (!empty($_POST['txt1']) && !empty($_POST['txt2']) && !empty($_POST['txt3']) && !empty($_POST['txt4']))
        {
            for($i=3;$i>0;$i--)
            {
                if($i==3)
                {
                    $price=$_POST['txt2'];
                    $pizza=$_POST['txt1'];
                    $query="update pizza set name_of_pizza='{$pizza}', price_standart='{$price}' where name_of_pizza='{$name_of_pizza}' and id_size={$i}";
                    $result=$mysqli->query($query);
                }
                if($i==2)
                {
                    $price=$_POST['txt3'];
                    $pizza=$_POST['txt1'];
                    $query="update pizza set name_of_pizza='{$pizza}', price_standart='{$price}' where name_of_pizza='{$name_of_pizza}' and id_size={$i}";
                    $result=$mysqli->query($query);
                }
                if($i==1)
                {
                    $price=$_POST['txt4'];
                    $pizza=$_POST['txt1'];
                    $query="update pizza set name_of_pizza='{$pizza}', price_standart='{$price}' where name_of_pizza='{$name_of_pizza}' and id_size={$i}";
                    $result=$mysqli->query($query);
                }
            }
            $content=
            "<script>
                window.location.href='http://localhost/Курсач/pizza1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
        else echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
    }
}
if (isset($_POST['btnDel']))
{
    $query="update pizza set flag='0' where name_of_pizza='{$name_of_pizza}'";
    $result=$mysqli->query($query);
    $content=
    "<script>
        window.location.href='http://localhost/Курсач/pizza1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
    </script>";
    echo $content;
}
?>
</form>
<?php
require_once("footer.php");
?>