<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
$id_size=$_GET['id_size'];
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
<h1>Редактирование коэффициента ценообразования</h1>
<?php
    $query="select * from sizeofpizza where id_size={$id_size}";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
?>
<table style="margin: auto; margin-top: 50px;">
    <tr>
        <td>Введите коэффициент: </td>
        <td><input type = "text" value="<?php echo $row['koef_of_size'];?>" name="txt1" id="txt1" autocomplete="off" class="textforcreateedit textforworkers"></td>
    </tr>
</table>
<input type="submit" value="Сохранить" name="btnSave" class="btn3 save">
<?php
if (isset($_POST['btnSave']))
{
    if (!empty($_POST['txt1']))
    {
        $koef_of_size=$_POST['txt1'];
        $query="update sizeofpizza set koef_of_size='{$koef_of_size}' where id_size={$id_size}";
        $result=$mysqli->query($query);
        if ($mysqli->affected_rows>0)
        $mysqli->close();
        $content=
            "<script>
                window.location.href='http://localhost/Курсач/koef1.php?timeofdelivery=$timeofdelivery&id_operator=$idoperator';
            </script>";
        echo $content;
    }
    else echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
}
?>
</form>
<?php
require_once("footer.php");
?>  