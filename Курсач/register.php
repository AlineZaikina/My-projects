<?php
require_once("inc.php");
require_once("mysql.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <script src="js/functions.js"></script>
    <title>Вход</title>
</head>
<body class="body">
    <form action="" method="post" class="form">
        <h3 class="form__title">Вход</h3>
        <div class="form__group">
            <input class="form__input" name="login" placeholder=" ">
            <label class="form__label">Логин</label>
        </div>
        <div class="form__group">
            <input type="password" class="form__input" name="password" placeholder=" ">
            <label class="form__label">Пароль</label>
        </div>
        <input type="submit" value="Войти" name="btnRegister" class="form__button">
        <?php
        if (isset($_POST['btnRegister']))
        {
            if (!empty($_POST['login']) && !empty($_POST['password']))
            {
                $login = $_POST['login'];
                $password = $_POST['password'];
                $query="select id_operator, fio_operator FROM operator WHERE password='{$password}' AND login='{$login}'";
                $result=$mysqli->query($query);
                $row=$result->fetch_assoc();
                if (isset($row['id_operator']))
                {
                    $idoperator = $row['id_operator'];
                    $content = 
                    "<script>
                        window.location.href='http://localhost/Курсач/neworder_checknumber.php?id_operator=$idoperator';
                    </script>";
                    echo $content;
                }
                else
                {
                    echo "<span class='notice'>Пользователь не найден!</span>";
                }
            }
            else
            {
                echo "<span class='notice'>Заполните все поля для входа!</span>";
            }
        }
        ?>
    </form>
</body>
</html>