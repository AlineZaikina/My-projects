<?php
require_once 'header.php';
?>
<body>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">№</th>
                <th scope="col">ФИО сотрудника</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Пол</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "select * from worker";
                $result=$mysqli->query($query);
                $i=1;
                while ($row=$result->fetch_assoc())
                {
                    $idworker = $row['id_worker'];
                    echo "<tr class=\"table__tr\" onclick=\"window.location='card_worker.php?idworker=$idworker'\">";
                    echo '<th scope="row">'.$i.'</th>';
                    echo '<td>'.$row["f_worker"].' '.$row["i_worker"].' '.$row["o_worker"].'</td>';
                    echo '<td>'.$row["date_worker"].'</td>';
                    echo '<td>';
                    if ($row["fm_worker"] == 1) echo 'Мужской';
                    else echo 'Женский';
                    echo '</td>';
                    echo '</tr>';
                    $i=$i+1;
                }
                ?>
            </tbody>
        </table>
        <div class="add_button">
            <a href="card_worker.php" class><button type="button" class="btn btn-outline-secondary">Добавить сотрудника</button></a>
        </div>
    </div>
<?php
require_once 'footer.php';
?>