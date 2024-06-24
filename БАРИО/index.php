
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>THE MAIN</title>
</head>
<body>
    <form class="container">
        <div class="group-input">
            <input type="number" id="a2" class="form-control group-input__input" placeholder="Продажная цена компании 1*" aria-label="Продажная цена компании 1*" aria-describedby="basic-addon1">
            <input type="number" id="b2" class="form-control group-input__input" placeholder="Продажная цена компании 2*" aria-label="Продажная цена компании 2*" aria-describedby="basic-addon1">
            <input type="number" id="c2" class="form-control group-input__input" placeholder="Продажная цена клиент*" aria-label="Продажная цена клиент*" aria-describedby="basic-addon1">
            <input type="number" id="d2" class="form-control group-input__input" placeholder="Доставка*" aria-label="Доставка*" aria-describedby="basic-addon1">
        </div>
        <h4>Коэффициенты распределения</h4>
        <table class="table koef-table">
            <thead>
                <tr>
                <th scope="col">Компания 1</th>
                <th scope="col">Компания 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" id="FirstKoef" class="noborder"></td>
                    <td><input type="number" id="SecondKoef" class="noborder"></td>
                </tr>
            </tbody>
        </table>
        <div class="form-check form-switch switch_left">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Оплата в рассрочку</label>
        </div>
        <div class="input-days">
            <input type="number" id="DaysOfPay" class="form-control group-input__input hidden" placeholder="Количество дней рассрочки" aria-label="Количество дней рассрочки" aria-describedby="basic-addon1">
        </div>
        <table class="table result-table">
            <thead>
                <tr>
                    <th scope="col">Компания</th>
                    <th scope="col">Итоговая прибыль, руб</th>
                    <th scope="col">Рентабельность, %</th>
                </tr>
            </thead>
            <tbody>
                <tr id="tr1">
                    <td>Компания 1</td>
                    <td id="1companyProfit"></td>
                    <td id="1companyRenta"></td>
                </tr>
                <tr id="tr2">
                    <td>Компания 2</td>
                    <td id="2companyProfit"></td>
                    <td id="2companyRenta"></td>
                </tr>
            </tbody>
        </table>
    </form>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>