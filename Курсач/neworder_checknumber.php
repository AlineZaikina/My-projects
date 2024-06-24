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
                        <td><a class="link1" style="color: rgb(251, 244, 198);" href="neworder_checknumber.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Новый <br>заказ</a></td>
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
                <span class="stage" style="color: rgb(251, 244, 198);">Назначение</span>
                <a class="stage" href="createclient.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Доставка</span></a>
                <a class="stage" href="createorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>"><span>Покупки</span></a>
                <a class="stage" href="confirmorder.php?timeofdelivery=<?=$timeofdelivery?>&id_operator=<?=$idoperator?>">Подтверждение</span></a>
            </div>
            <form action="" method="post" class="content">
                <table style="border-spacing: 5px;">
                    <tr>
                        <td>
                        <?php 
                        if (isset($_POST['txt1']) && !empty($_POST['txt1']))
                            { $txt=$_POST['txt1'];}
                        else
                        {
                            $txt="";
                        }
                        ?>    
                        <input type="tel" name="txt1" maxlength="12" id="txt1" placeholder = "+7(900)123-45-67" 
                        autocomplete="off" class="textfornumber" value="<?php echo $txt;?>" pattern="^((\+7|7|8)+([0-9]){10})$"></td>
                        <td><input type="submit" class="btn1" value="Найти" id="btnFind" name="btnFind"></td>
                    </tr>
                </table>
<?php
if (isset($_POST['btnFind']))
{
    if (!empty($_POST['txt1']))
    {
        $query="select * from client where number={$_POST['txt1']}";
        $number = $_POST['txt1'];
        $result=$mysqli->query($query);
        $row=$result->fetch_assoc();
        if ($row != NULL) 
        {
            $query1="select count(*) as quantity FROM orders WHERE id_client={$row['id_client']}";
            $result1=$mysqli->query($query1);
            $row1=$result1->fetch_assoc();
            echo '<p class="sign1">По номеру '.$number.' найдены клиенты:</p>';
            echo "<br>";
            echo "<a class=\"link2_1\" href='editclient.php?id_client=".$row['id_client']."&timeofdelivery=".$timeofdelivery."&id_operator=".$idoperator."'><div class=\"name1\">{$row['fio_client']}<p class=\"counteroforders\">Сделал(а) {$row1['quantity']} заказа</p></div></a>";
        }
        else
        {
            echo '<p class="sign2">По номеру '.$number.' не найдено клиентов!</p>';
            echo "<br>";
            echo "<a class=\"link2_1\" href='createclient.php?number=".$number."&timeofdelivery=".$timeofdelivery."&id_operator=".$idoperator."'><div class=\"btn2\">Создать</div></a>";
        }
    }
    if (empty($_POST['txt1']))
    {
        echo"<p class=\"sign3\">Для поиска клиентов необходимо заполнить поле!</p>";
        exit;
    }
}
?> 
</form>
<?php
require_once("footer.php");
?>        