<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['id_operator_select']))
$id_operator=$_GET['id_operator_select'];
else $id_operator=0;
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
<h1>Создание/Редактирование оператора</h1>
<?php
if ($id_operator>0)
{
    $query="select * from operator where id_operator={$id_operator}";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
}
?>
<table style="margin: auto; margin-top: 50px; border-spacing: 20px 30px;">
    <tr>
        <td>Введите имя оператора: </td>
        <td><input type = "text" value="<?php if ($id_operator>0) echo $row['fio_operator']; else echo "";?>" name="txt1" id="txt1" autocomplete="off" class="textforcreateedit textforworkers"></td>
    </tr>
    <tr>
        <td>Введите логин: </td>
        <td><input type = "text" value="<?php if ($id_operator>0) echo $row['login']; else echo "";?>" name="txt2" id="txt2" autocomplete="off" class="textforcreateedit textforworkers"></td>
    </tr>
    <tr>
        <td>Введите пароль: </td>
        <td><input type = "text" value="<?php if ($id_operator>0) echo $row['password']; else echo "";?>" name="txt3" id="txt3" autocomplete="off" class="textforcreateedit textforworkers"></td>
    </tr>
</table>
<input type="submit" value="Сохранить" name="btnSave" class="btn3 save">
<?php
if (isset($_POST['btnSave']))
{
    if ($id_operator==0)
    {
        if (!empty($_POST['txt1']))
        {
            $fio_operator=$_POST['txt1'];
            $login=$_POST['txt2'];
            $password=$_POST['txt3'];
            $query="insert into operator values('','{$fio_operator}','{$login}','{$password}','1')";
            $result=$mysqli->query($query);
            if ($mysqli->affected_rows>0)
            $mysqli->close();
            $content=
            "<script>
                window.location.href='http://localhost/Курсач/operator1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
        else echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
    }
    if ($id_operator>0)
    {
        if (!empty($_POST['txt1']))
        {
            $fio_operator=$_POST['txt1'];
            $login=$_POST['txt2'];
            $password=$_POST['txt3'];
            $query="update operator set fio_operator='{$fio_operator}', login='{$login}', password='{$password}' where id_operator={$id_operator}";
            $result=$mysqli->query($query);
            if ($mysqli->affected_rows>0)
            $mysqli->close();
            $content=
            "<script>
                window.location.href='http://localhost/Курсач/operator1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
            echo $content;
        }
        else echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
    }
}
?>      
</form>
<?php
require_once("footer.php");
?>      