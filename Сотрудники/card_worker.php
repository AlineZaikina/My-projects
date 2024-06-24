<?php
require_once 'header.php';
if (isset($_GET['idworker']))
{
    $idworker=$_GET['idworker'];
    $query="select * from worker where id_worker={$idworker}";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
}
?>
<body>
    <form action="" method="post" class="container">
        <h2>Информация о сотруднике</h2>
        <div class="card">
            <input type="text" name="familia" class="form-control card__input" placeholder="Фамилия" aria-label="Username" aria-describedby="basic-addon1"
            value="<?php if (isset($_GET['idworker'])) echo $row['f_worker'];?>">
            <select name="fm" class="form-control card__input">
                <?php
                if (isset($_GET['idworker']))
                {
                    if ($row['fm_worker'] == 0)
                    {
                        echo '<option value="0" selected>Женский</option>';
                        echo '<option value="1">Мужской</option>';
                    }
                    else
                    {
                        echo '<option value="1" selected>Мужской</option>';
                        echo '<option value="0">Женский</option>';
                    }
                }
                else
                {
                    echo '<option value="1">Мужской</option>';
                    echo '<option value="0">Женский</option>';
                }
                ?>  
            </select>
            <input type="text" name="name" class="form-control card__input" placeholder="Имя" aria-label="Username" aria-describedby="basic-addon1"
            value="<?php if (isset($_GET['idworker'])) echo $row['i_worker'];?>">
            <input type="date" name="birthdate" class="form-control card__input" placeholder="Дата рождения" aria-label="Username" aria-describedby="basic-addon1"
            value="<?php if (isset($_GET['idworker'])) echo $row['date_worker'];?>">
            <input type="text" name="otchestvo"class="form-control card__input" placeholder="Отчество" aria-label="Username" aria-describedby="basic-addon1"
            value="<?php if (isset($_GET['idworker'])) echo $row['o_worker'];?>">
        </div>
        <h2>Прошлые места работы</h2>
        <table class="table" id="table1">
            <thead>
                <tr>
                <th scope="col">№</th>
                <th scope="col">Дата начала работы</th>
                <th scope="col">Дата окончания работы</th>
                <th scope="col">Организация</th>
                <th scope="col">Удаление</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['idworker']))
                {
                    $query="select * from workplace where id_worker={$idworker}";
                    $result=$mysqli->query($query);
                    $i=1;
                    while ($row=$result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo '<td>'.$i.'</td>';
                        echo '<td><input type="date" value="'.$row['first_date'].'" class="noborder" name="datebeg'.$i.'"></td>';
                        echo '<td><input type="date" value="'.$row['last_date'].'" class="noborder" name="dateend'.$i.'"></td>';
                        echo "<td><input value='".$row["workplace"]."' class='border_bottom' name='place".$i."'></td>";
                        echo '<td><input type="button" id="'.$i.'" value="Удалить" class="btn btn-outline-secondary" onclick="DeleteStr(this);"></td>';
                        echo "</tr>";
                        $i=$i+1;
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="add_button">
            <input type="button" class="btn btn-outline-secondary" value="+" id="add-string">
        </div>
        <div class="group_button">
            <input type="submit" class="btn btn-outline-secondary" value="Сохранить изменения" id="btnSave" name="btnSave">
            <input type="submit" class="btn btn-outline-secondary" value="Удалить сотрудника" id="btnDel" name="btnDel">
        </div>
        <?php
        if (isset($_POST['btnSave']))
        {
            if (isset($_GET['idworker']))
            {
                if (!empty($_POST['familia']) && !empty($_POST['name']) && !empty($_POST['birthdate']) && !empty($_POST['otchestvo'])) 
                { 
                    $familia = $mysqli->real_escape_string($_POST['familia']);
                    $fm = $mysqli->real_escape_string($_POST['fm']);
                    $name = $mysqli->real_escape_string($_POST['name']);
                    $birthdate = $mysqli->real_escape_string($_POST['birthdate']);
                    $otchestvo = $mysqli->real_escape_string($_POST['otchestvo']);
                    $query="update worker set f_worker='{$familia}', i_worker='{$name}', o_worker='{$otchestvo}', date_worker='{$birthdate}', fm_worker='{$fm}' where id_worker={$idworker}";
                    $result=$mysqli->query($query);
                    $query1="delete from workplace where id_worker={$idworker}";
                    $result1=$mysqli->query($query1);
                    if (isset($_POST['datebeg1']))
                    {
                        $i=1;
                        while (isset($_POST["datebeg$i"]) && !empty($_POST["datebeg$i"]) && !empty($_POST["dateend$i"]) && !empty($_POST["place$i"]))
                        {
                            $datebeg=$mysqli->real_escape_string($_POST["datebeg$i"]);
                            $dateend=$mysqli->real_escape_string($_POST["dateend$i"]);
                            $place=$mysqli->real_escape_string($_POST["place$i"]);
                            $query="insert into workplace values('{$idworker}','{$datebeg}','{$dateend}','{$place}')";
                            $result=$mysqli->query($query);
                            $i=$i+1;
                        }
                    }
                }
            }
            else
            {
                if (!empty($_POST['familia']) && !empty($_POST['name']) && !empty($_POST['birthdate']) && !empty($_POST['otchestvo'])) 
                { 
                    $familia = $mysqli->real_escape_string($_POST['familia']);
                    $fm = $mysqli->real_escape_string($_POST['fm']);
                    $name = $mysqli->real_escape_string($_POST['name']);
                    $birthdate = $mysqli->real_escape_string($_POST['birthdate']);
                    $otchestvo = $mysqli->real_escape_string($_POST['otchestvo']);
                    $query="insert into worker values('','{$familia}','{$name}','{$otchestvo}','{$birthdate}','{$fm}')";
                    $result=$mysqli->query($query);
                    if (isset($_POST['datebeg1']) && !empty($_POST["datebeg1"]) && !empty($_POST["dateend1"]) && !empty($_POST["place1"]))
                    {
                        $query = "select id_worker from worker ORDER BY id_worker DESC LIMIT 1";
                        $result=$mysqli->query($query);
                        $row=$result->fetch_assoc();
                        $idworker=$row['id_worker'];
                        $i=1;
                        while (isset($_POST["datebeg$i"]) && !empty($_POST["datebeg$i"]) && !empty($_POST["dateend$i"]) && !empty($_POST["place$i"]))
                        {
                            $datebeg=$mysqli->real_escape_string($_POST["datebeg$i"]);
                            $dateend=$mysqli->real_escape_string($_POST["dateend$i"]);
                            $place=$mysqli->real_escape_string($_POST["place$i"]);
                            $query="insert into workplace values('{$idworker}','{$datebeg}','{$dateend}','{$place}')";
                            $result=$mysqli->query($query);
                            $i=$i+1;
                        }
                    }
                } 
            }
            $content = 
                "<script>
                    window.location.href='http://localhost/Сотрудники/index.php';
                </script>";
            echo $content;    
        }
        if (isset($_POST['btnDel']))
        {
            if (!empty($_POST['familia']) && !empty($_POST['name']) && !empty($_POST['birthdate']) && !empty($_POST['otchestvo'])) 
            {
                if (isset($_POST['datebeg1']))
                {
                    $query="delete from workplace where id_worker={$idworker}";
                    $result=$mysqli->query($query);
                }
                $query="delete from worker where id_worker={$idworker}";
                $result=$mysqli->query($query);
                $mysqli->close();
                $content = 
                    "<script>
                        window.location.href='http://localhost/Сотрудники/index.php';
                    </script>";
                echo $content;
            }
        }
        ?>    
    </form>
<?php
require_once 'footer.php';
?>