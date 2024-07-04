<?php
$url = 'http://ch322.ru:3000/categories.lunches';

// Получение содержимого URL
$jsonData = file_get_contents($url);

// Проверка успешности получения данных
if ($jsonData === FALSE) {
    die('Ошибка при получении данных');
}

// Декодирование JSON-строки в PHP массив
$data = json_decode($jsonData, true);

// Проверка успешности декодирования JSON
if ($data === NULL) {
    die('Ошибка при декодировании JSON');
}

// Теперь данные сохранены в переменной $data
// Вы можете работать с ними как с обычным PHP массивом

// Пример вывода данных
// echo '<pre>';
// print_r($data);
// echo '</pre>';
$first_date = $_GET["first_date"];
$last_date = $_GET["last_date"];
require_once("header.php")
?>
<script>
    let categories = <?php echo json_encode($data); ?>;
    let first_date = <?php echo json_encode($first_date); ?>;
    let last_date = <?php echo json_encode($last_date); ?>;
</script>
    <form method="post" class="choose-food__form">
        <h3 class="choose-food__form__h3">Меню на <span id="dateOfChoose"></span></h3> 
        <div class="choose-food__form__group">
        </div>
        <div class="choose-food__form__button">
            <button type="button" class="btn btn-primary" id="Check">Проверить заполнение</button>
            <button type="button" class="btn btn-primary" id="Next">Перейти к следующему дню</button>
        </div>
        
    </form>
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        window.onload = GetCategories;
        document.getElementById("Next").onclick = RememberFilling;
        document.getElementById("Check").onclick = CheckFilling;
    </script>
</body>
</html>