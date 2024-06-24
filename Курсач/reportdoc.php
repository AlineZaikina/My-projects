<?php
require_once("inc.php");
require_once("mysql.php");
require_once("header.php");
if (isset($_GET['dateofreport']))
{
    $dateofreport = $_GET['dateofreport'];
}
$idoperator = $_GET['id_operator'];
?>
<body>
    <header class="header-grid">
        <div class="header-grid-item">
            <h1 class="h1 report-h1">ООО Пицца Рикка</h1>
            <h1 class="h1 report-h1">526106928300</h1>
            <?php
            $query="select adress from pointofpizzaria where id_point=1";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            ?>
            <h1 class="h1 report-h1">Адрес: <?php echo $row['adress']; ?></h1>
        </div>
        <div class="header-grid-item">
            <h1 class="h1 report-h1">Отчет от <?php echo $dateofreport; ?></h1>
        </div>
        <div class="header-grid-item">
            <?php
            $nowhour = date("H") + 1;
            $now = date(":i d.m.Y");
            $query="select fio_operator from operator where id_operator={$idoperator}";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            ?>
            <h1 class="h1 report-h1">Время печати: <?php echo $nowhour, $now; ?></h1>
            <h1 class="h1 report-h1">Оператор: <?php echo $row['fio_operator']; ?></h1>
        </div>
    </header>
    <section class="report-table">
        <table border=3 align="center" class="t3" style="border-collapse: collapse; margin-top: 10px; width: 1000px; border: 2px solid black; ">
        <tr>
            <td class="bolden">Сумма по чекам</td>
            <?php
            $query="select sum(cost_of_order) as sumoforder, count(id_order) as quan, sum(cost_of_order)/count(id_order) as middle from orders where date='{$dateofreport}'";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
            ?>
            <td class="bolden"><?php echo $row['sumoforder'];?></td>
            <td class="bolden">Количество заказов</td>
            <td class="bolden"><?php echo $row['quan'];?></td>
        </tr>
        <tr>
            <td class="bolden">Средняя сумма заказа по чекам</td>
            <td class="bolden"><?php echo $row['middle'];?></td>
            <?php
            $query="select timeofdelivery.id_time AS idtime, (SELECT COUNT(id_order) FROM `orders` WHERE orders.id_time = idtime AND date='{$dateofreport}') as counter FROM timeofdelivery GROUP BY idtime";
            $result=$mysqli->query($query);
            ?>
            <td class="bolden">Время доставки</td>
            <td class="bolden">
            <?php
            while ($row=$result->fetch_assoc())
            {
                if ($row['idtime'] == 3)
                {
                    echo $row['counter'];
                }
                else
                {
                    echo $row['counter'];
                    echo "/";
                }
            }
            ?>
            </td>
        </tr>
        <tr>
            <td class="bolden">Оплата наличными</td>
            <?php
            $query="select kassa from pointofpizzaria where id_point=1";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc(); 
            ?>
            <td class="bolden">Касса - <?php echo $row['kassa']; ?></td>
            <td class="bolden">Сумма по оплате наличными</td>
            <?php
            $query="select sum(cost_of_order) as summa from orders where type_of_pay=0 and date='{$dateofreport}'";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc(); 
            ?>
            <td class="bolden"><?php echo $row['summa']?></td>
        </tr>
        <tr>
            <td class="bolden" colspan=4 style="padding: 0 10px;">
            <?php
            $query="select * from orders where type_of_pay=0 and date='{$dateofreport}'";
            $result=$mysqli->query($query);
            while ($row=$result->fetch_assoc())
            {
                echo "№";
                echo $row['id_order'];
                echo " от ";
                echo $row['date'];
                echo " ";
                echo "(";
                echo $row['cost_of_order'];
                echo "p. ";
                echo $row['time_order'];
                echo "), ";
            }
            ?>
            </td>
        </tr>
        <tr>
            <td class="bolden">Онлайн оплата</td>
            <?php
            $query="select terminal from pointofpizzaria where id_point=1";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc(); 
            ?>
            <td class="bolden">Терминал - <?php echo $row['terminal']; ?></td>
            <td class="bolden">Сумма по онлайн оплате</td>
            <?php
            $query="select sum(cost_of_order) as summa from orders where type_of_pay=1 and date='{$dateofreport}'";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc(); 
            ?>
            <td class="bolden"><?php echo $row['summa']?></td>
        </tr>
        <tr>
            <td class="bolden" colspan=4 style="padding: 0 10px;">
            <?php
            $query="select * from orders where type_of_pay=1 and date='{$dateofreport}'";
            $result=$mysqli->query($query);
            while ($row=$result->fetch_assoc())
            {
                echo "№";
                echo $row['id_order'];
                echo " от ";
                echo $row['date'];
                echo " ";
                echo "(";
                echo $row['cost_of_order'];
                echo "p. ";
                echo $row['time_order'];
                echo "), ";
            }
            ?>
            </td>
        </tr>
            <?php
            $query="select c.id_courier, c.fio_courier, COUNT(o.id_courier) FROM courier c left join orders o on c.id_courier=o.id_courier WHERE o.date = '{$dateofreport}' GROUP BY c.id_courier HAVING COUNT(o.id_courier) >=1";
            $result=$mysqli->query($query);
            while ($row=$result->fetch_assoc())
            {
                echo "<tr>";
                echo "<td class='bolden' colspan=3>";
                echo $row['fio_courier'];
                echo "</td>";
                echo "<td class='bolden'>";
                echo $row['COUNT(o.id_courier)'];
                echo "</td>";
                echo "</tr>";
            }
            ?>
        <tr>
            <td class="bolden" colspan=2>Подпись____________________</td>
            <td class="bolden" colspan=2>Расшифровка____________________</td>
        </tr>
        </table>
        <section class="group_of_buttons" style="margin-top: 30px;">
        <a class="btn_print" href="javascript:(print());">Печать</a>
        <a class="btn4" href="createreport.php?id_operator=<?=$idoperator?>">Назад</a>
    </section>
    </section>
</body>
