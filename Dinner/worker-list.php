<?php
$url = 'http://ch322.ru:3000/users';

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

require_once("header.php")
?>
<script>
  let workers = <?php echo json_encode($data); ?>;
</script>
    <form method="post" class="worker-list__form">
        <table class="table table-hover" id="worker-table">
            <thead>
              <tr>
                <th scope="col">№</th>
                <th scope="col">ФИО</th>
                <th scope="col">Обед</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="choose-food__form__button">
          <input class="btn btn-primary" type="button" id="btnAccept" value="Применить">
        </div>
    </form>
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
      window.onload = GetEmployees;
      document.getElementById("btnAccept").onclick = SendEmployees;
    </script>
</body>
</html>