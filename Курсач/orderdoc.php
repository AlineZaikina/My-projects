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
$query="select * from orders where id_order={$id_order}";
$result=$mysqli->query($query);
$row=$result->fetch_assoc();
if ($row["type_of_pay"] == 1)
{
    $typeofpay = 1;
}
else
{
    $typeofpay = 0;
}
?>
<body>
    <header class="header">
        <h1 class="h1">Заказ № <?php if ($id_order>0) echo $row['id_order']; else echo "";?> от <?php if ($id_order>0) {echo $row['date']; echo " "; echo $row['time_order'];} else echo "";?></h1>
        <table border=1 align="center" class="t3" style="border-collapse: collapse;">
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
                    echo "<td>".$row1['price_standart'] * $row1['koef_of_size']." ₽</td>";
                    echo "<td>".$row1['price_standart'] * $row1['koef_of_size'] * $row1['quantity']." ₽</td>";
                    echo "</tr>";
                    $i=$i+1;
                }
            }
            if ($typeofpay == 1)
            {
                echo "<tr>";
                echo "<td colspan=4></td>";
                echo "<td>Оплата онлайн</td>";
                echo '<td><b>Оплачен</b></td>';
                echo "</tr>";
            }
            else
            {
                echo "<tr>";
                echo "<td colspan=4></td>";
                echo "<td>Оплата наличными</td>";
                echo '<td><b>-</b></td>';
                echo "</tr>";
            }
            ?>
            <tr>
                <td colspan=5>Итого</td>
                <td><?php if ($id_order>0) echo $row['cost_of_order']; else echo "";?> ₽</td>
            </tr>
        </table>
        <div class="info">
            <h2>PIZZA RICCA</h2>
            <h2>8 (831) 260-10-60</h2>
            <h2>www.pizzaricca.ru</h2>
        </div>
        <p class="client_text">
            Уважаемые клиенты, если у Вас есть какие-либо замечания (некачественный товар, грубое обращение сотрудников, 
            нарушение комплектности, несоответствие сроков доставки, заявленных оператором) по поводу работы нашего заведения, 
            просим обращаться по номеру: 8 (920) 006-22-44 (Контроль качества с 10:30 до 21:30).
        </p>
    </header>
    <div class="line"></div>
    <section class="courier_list">
        <div class="courier_list-header">
            <h1 class="h1">БУДЬТЕ ВНИМАТЕЛЬНЫ!!!</h1>
            <h1 class="h1">Заказ № <?php if ($id_order>0) echo $row['id_order']; else echo "";?></h1>
            <p>Зарегестрирован: <?php if ($id_order>0) {echo $row['date']; echo " "; echo $row['time_order'];} else echo "";?></p>
        </div>
        <p class="client_text">Накладные с рукописными изменениями, сделанные любым лицом, кроме клиента, не действительны. Претензии по
            данным накладным не принимаются. Товар получен, претензий по кол-ву и качеству не имею
        </p>
        <br>
        <p class="client_text">Подпись:________________   Расшифровка:_______________________</p>
        <?php 
            $query="select * from orders, client where id_order={$id_order} and orders.id_client=client.id_client";
            $result=$mysqli->query($query);
            $row=$result->fetch_assoc();
        ?>
        <table border=1 align="center" class="t3" style="border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td rowspan=2>
                    <?php 
                    if ($id_order>0)
                    {
                        echo $row['street'].','.$row['house'];
                        if (!empty($row['flat'])) echo ', кв '.$row['flat']; 
                        if (!empty($row['entrance'])) echo ', подъезд '.$row['entrance'];
                        if (!empty($row['floor'])) echo ', этаж '.$row['floor'];
                    } 
                    else echo "";
                    ?></td>
                <td>Итого: <?php if ($id_order>0) echo $row['cost_of_order']; else echo "";?> ₽</td>
            </tr>
            <tr>
                <td><?php if ($id_order>0) {echo $row['number']; echo " "; echo $row['fio_client'];} else echo "";?></td>
            </tr>
            <tr>
                <td colspan=2 style="text-align: start; padding-left: 5px;">Примечание: <?php if ($id_order>0) {echo $row['comment_for_order'];} else echo "";?></td>
            </tr>
        </table>
    </section>
    <div class="line"></div>
    <section class="operator_list container_for_footer">
        <div class="grid-left">
            <div class="grid-left_header">
                <h1 class="h1">Заказ № <?php if ($id_order>0) echo $row['id_order']; else echo "";?> от <?php if ($id_order>0) {echo $row['date']; echo " "; echo $row['time_order'];} else echo "";?></h1>
                <p>Зарегестрирован: <?php if ($id_order>0) {echo $row['date']; echo " "; echo $row['time_order'];} else echo "";?></p>
            </div>
            <table border=1 align="start" class="t4">
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
                    echo "<td>".$row1['price_standart'] * $row1['koef_of_size']." ₽</td>";
                    echo "<td>".$row1['price_standart'] * $row1['koef_of_size'] * $row1['quantity']." ₽</td>";
                    echo "</tr>";
                    $i=$i+1;
                }
            }
            if ($typeofpay == 1)
            {
                echo "<tr>";
                echo "<td colspan=4></td>";
                echo "<td>Оплата онлайн</td>";
                echo '<td><b>Оплачен</b></td>';
                echo "</tr>";
            }
            else
            {
                echo "<tr>";
                echo "<td colspan=4></td>";
                echo "<td>Оплата наличными</td>";
                echo '<td><b>-</b></td>';
                echo "</tr>";
            }
            ?>
            <tr>
                <td colspan=5>Итого</td>
                <td><?php if ($id_order>0) echo $row['cost_of_order']; else echo "";?> ₽</td>
            </tr>
            </table>
            <p>
                <?php 
                if ($id_order>0) 
                {
                    echo $row['street'].','.$row['house'];
                    if (!empty($row['flat'])) echo ', кв '.$row['flat']; 
                    if (!empty($row['entrance'])) echo ', подъезд '.$row['entrance'];
                    if (!empty($row['floor'])) echo ', этаж '.$row['floor'];
                } 
                else echo "";
                ?></p>
            <p>Телефон: <?php if ($id_order>0) {echo $row['number']; echo " "; echo $row['fio_client'];} else echo "";?></p>
        </div>
        <div class="grid-right">
            <table border=1 align="center" class="t3" style="border-collapse: collapse; margin-top: 60px; width: 300px;">
            <tr>
                <td colspan=4>Заказ № <?php if ($id_order>0) echo $row['id_order']; else echo "";?></td>
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
                    echo "<td>".$row1['quantity']." шт.</td>";
                    echo "</tr>";
                    $i=$i+1;
                }
            }
            ?>
            </table>
        </div>
    </section>
    <?php
    if ($_GET['rej'] == 1)
    {
        $content = "href='confirmorder.php?id_order=$id_order&timeofdelivery=$timeofdelivery&id_operator=$idoperator'";
    }
    else
    {
        $content = "href='confirmorder2.php?id_order=$id_order&timeofdelivery=$timeofdelivery&id_operator=$idoperator'";
    }
    ?>
    <section class="group_of_buttons">
        <a class="btn_print" href="javascript:(print());">Печать</a>
        <a class="btn4" <?php echo $content ?>>Назад</a>
    </section>
</body>