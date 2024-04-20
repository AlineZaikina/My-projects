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
    <span class="stage" style="color: rgb(251, 244, 198);">Доставка</span>
    <a class="stage" href="createorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Покупки</span></a>
    <a class="stage" href="confirmorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Подтверждение</span></a>
</div>
<form action="" method="post" class="content">
<div class="h1">Введите данные о клиенте</div>
<table class="createtable">
    <tr>
        <td colspan=4>Номер* <input type="tel" name="txt2" maxlength="12" id="txt2" placeholder = "+7(900)123-45-67" 
         autocomplete="off" pattern="^((\+7|7|8)+([0-9]){10})$" value=
         "<?php  
                if (isset($_GET['number']))
                echo '+'.trim($_GET['number']);
                else
                echo "";?>" 
        class="textforcreateedit"></td>
    </tr>
    <tr>
        <td colspan=4>Имя* <input type = "text" name="txt3" id="txt3" autocomplete="off" class="textforcreateedit" placeholder = "Иван"></td>
    </tr>
    <tr>
        <td colspan=4>Улица* <input type = "text" name="street" id="street" autocomplete="off" class="textforcreateedit" placeholder = "ул. Ивановская"></td>
    </tr>
    <tr>
        <td>Дом* <br><input type = "text" name="house" id="house" autocomplete="off" class="textforcreateedit" placeholder = "д 11"></td>
        <td>Квартира <br><input type = "text" name="txt6" id="txt6" autocomplete="off" class="textforcreateedit" placeholder = "123"></td>
        <td>Подъезд <br><input type = "text" name="txt7" id="txt7" autocomplete="off" class="textforcreateedit" placeholder = "2"></td>
        <td>Этаж <br><input type = "text" name="txt8" id="txt8" autocomplete="off" class="textforcreateedit" placeholder = "12"></td>
    </tr>
    <tr>
        <input id="city" name="city" value="г Нижний Новгород" type="text" style="display: none;"/>  
    </tr>
</table>
<input type="submit" style="margin: 0 auto; display: block;" class="btn1" value="Далее" id="btnContinue" name="btnContinue">
<?php
if (isset($_POST['btnContinue']))
{
    if (empty($_POST['txt3']) || empty($_POST['house']) || empty($_POST['txt2']) || empty($_POST['street'])) 
    {
        echo "<p style=\"text-align: center; margin: 0 auto; display: block; margin-top: 50px;\" class=\"sign3\">Заполните все поля!</p>";
    }
    if (!empty($_POST['txt3']) && !empty($_POST['txt2']) && !empty($_POST['house']) && !empty($_POST['street'])) 
    {
        $number=$mysqli->real_escape_string($_POST['txt2']);
        $fio_client=$mysqli->real_escape_string($_POST['txt3']);
        $street=$mysqli->real_escape_string($_POST['street']);
        $house=$mysqli->real_escape_string($_POST['house']);
        $flat=$mysqli->real_escape_string($_POST['txt6']);
        $entrance=$mysqli->real_escape_string($_POST['txt7']);
        $floor=$mysqli->real_escape_string($_POST['txt8']);
        $query="insert into client values('','{$fio_client}','{$street}','{$house}','{$flat}','{$entrance}','{$floor}','{$number}')";
        $result=$mysqli->query($query);
        if ($mysqli->affected_rows>0)
            /*echo "<p>Данные добавлены успешно!";
        else
            echo "<p>Что-то пошло не так ".$mysqli->error;*/
        if (isset($_GET['number']))
        {
            $query="select * from client where number={$_GET['number']}";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            $id = $row['id_client'];
        }
        else
        {
            $query="select id_client from client ORDER BY id_client DESC LIMIT 1";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            $id = $row['id_client'];
        }
        $content = 
        "<script>
            window.location.href='http://localhost/Курсач/createorder.php?id_client=$id&timeofdelivery=$timeofdelivery&id_operator=$idoperator';
        </script>";
        echo $content;
    }
}
?> 
</form>
<?php
require_once("footer.php");
?>      