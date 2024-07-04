var arr_date = [];
var counter = 0;
var category = [];
var data = {};
var flag = false;
function GetEmployees()
{
    
    workers.sort((a,b) => a.full_name > b.full_name ? 1 : -1);
    let table = document.getElementById("worker-table");
    workers.forEach((user) => {
        let row = table.insertRow();
        let cell1 = row.insertCell();
        let cell2 = row.insertCell();
        let cell3 = row.insertCell();
        cell1.innerHTML = table.rows.length - 1;
        cell2.textContent = user.full_name;
        cell3.innerHTML = 
        `<div class="form-check form-switch">
            <input class="form-check-input" name="checkbox" value="${user.id}" type="checkbox" id="flexSwitchCheckDefault">
        </div>`;
    });
}
function SendEmployees()
{
    let arr_for_id = [];
    let checkbox = document.getElementsByName("checkbox");
    checkbox.forEach((cb) => {
        if (cb.checked) arr_for_id.push(cb.value);
    });
    alert(arr_for_id);
    
}
function GetCategories()
{
    categories.sort((a,b) => a.name > b.name ? 1 : -1);
    let container = document.querySelector('.choose-food__form__group');
    categories.forEach((cat) => {
        let details = document.createElement('details');
        details.className = "choose-food__form__details";
        details.innerHTML = 
        `<summary class="choose-food__form__summary" id="${cat.id}">${cat.name}</summary>
            <p><div class="form-group">
                <textarea class="form-control choose-food__form__textarea-dish" id="exampleFormControlTextarea1" rows="3" placeholder="Заполните меню"></textarea>
                <textarea class="form-control choose-food__form__textarea-price" id="exampleFormControlTextarea2" rows="3" placeholder="Заполните цены"></textarea>
                </div>
            </p>`
        container.appendChild(details);
    });
    InitDate();
}
function GetDate()
{
    var first_date = document.getElementById("first_date").value;
    var last_date = document.getElementById("last_date").value;
    window.location.href = `choose-food.php?first_date=${first_date}&last_date=${last_date}`;
}
function InitDate()
{   
    let currentDate = new Date(first_date);

    while (currentDate <= new Date(last_date)) {
        arr_date.push(new Date(currentDate));
        currentDate.setDate(currentDate.getDate() + 1);
    }
    ShowDate();
}
function ShowDate()
{
    let rightmonth = arr_date[counter].getMonth() + 1;
    let month = ("0" + rightmonth).slice(-2);
    let day = ("0" + (arr_date[counter].getDate())).slice(-2);
    let year = arr_date[counter].getFullYear();
    document.getElementById("dateOfChoose").textContent = (day + "." + month + "." + year);
}
function extractPrice(priceString) 
{
    let priceRegex = /(\d+(\.\d+)?)/;
    let matches = priceString.match(priceRegex);
    return matches ? parseFloat(matches[0]) : null;
      
}
function GetData()
{
    var details = document.querySelectorAll(".choose-food__form__details");
    details.forEach(de => {
        id_node = de.childNodes[0].id;
        text_node = de.childNodes[3].childNodes[1].value;
        price_node = de.childNodes[3].childNodes[3].value;
        
        var dish = new Array();
        var price = new Array();
        var dishes = new Array();
        var prices = new Array();
        if (text_node !== "")
        {
            dish.push(text_node.split('\n').filter(line => line.trim() !== '').map(line => line.replace(/\t+/g, ''))); 
            dishes = dish.flat();
        }
        if (price_node !== "") {
        let lines = price_node.split('\n').filter(line => line.trim() !== '');
        let linePrices = lines.map(line => {
            let cleanLine = line.replace(/\t+/g, '');
            return extractPrice(cleanLine);
        });
        price.push(linePrices);
        prices = price.flat();
        }
        if(dishes.length === prices.length && dishes.length !== 0)
        {
            if (typeof data[arr_date[counter]] === 'undefined') {
                data[arr_date[counter]] = [];
            }
            for (let i = 0; i < dishes.length; i++) {
                data[arr_date[counter]].push([dishes[i],prices[i],id_node]);
            }
        }
    });
    console.log(data); 
}
function RememberFilling()
{ 
    counter++;
    if (flag)
    {   
        //console.log(data);
        let container = document.querySelector('.choose-food__form__group');
        container.innerHTML = '';
        GetCategories();
    }
    else
    {
        GetData();
        document.querySelectorAll(".form-control").forEach(ta => {
            ta.value = "";
        });
    }
    ShowDate();
    flag = false;
    window.scrollTo({top: 0, behavior: 'smooth'});
    if (counter == (arr_date.length - 1)) openCustomAlert();
}
function CheckFilling()
{
    flag = true;
    GetData();
    console.log(data);
    var details = document.querySelectorAll(".choose-food__form__details");
    details.forEach(de => {
        idcategory = de.childNodes[0].id;
        text_node = de.childNodes[3].childNodes[1];
        price_node = de.childNodes[3].childNodes[3];
        if (text_node.value !== "" && price_node.value !== "")
        {
            price_node.remove();
            text_node.remove();
            de.childNodes[3].innerHTML = 
            `<table class="table table-hover" id="dish-table${idcategory}">
            <thead>
              <tr>
                <th scope="col">№</th>
                <th scope="col">Блюдо</th>
                <th scope="col">Цена</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>`;
        }
        let table = document.getElementById(`dish-table${idcategory}`);
        let filterData = [];
        //debugger;
        if (data[arr_date[counter]].length !== 0)
        {
            for (let i = 0; i < data[arr_date[counter]].length; i++) {
                if (data[arr_date[counter]][i][2] == idcategory) {
                    filterData.push(data[arr_date[counter]][i]);
                }
            }
            for (let i = 0; i < filterData.length; i++)
            {
                let row = table.insertRow();
                let cell1 = row.insertCell();
                let cell2 = row.insertCell();
                let cell3 = row.insertCell();
                cell1.textContent = table.rows.length - 1;
                cell2.innerHTML = `<input type="text" class="choose-food__form__input" value="${filterData[i][0]}">`;
                cell3.innerHTML = `<input type="text" class="choose-food__form__input" value="${filterData[i][1]}">`;  
            }  
        }
    });
    window.scrollTo({top: 0, behavior: 'smooth'});
}  
function openCustomAlert() {
    let modal = document.createElement('div');
    modal.className = "modal fade";
    modal.id = "dynamicModal";
    modal.tabIndex = "-1";
    modal.role = "dialog";
    modal.innerHTML = 
      `<div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Заполнение меню на указанный период завершено.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="finishBtn">Завершить</button>
          </div>
        </div>
      </div>`;
    document.body.appendChild(modal); // Добавляем модальное окно в тело документа
  
    // Обработчик для кнопки "Завершить", который перенаправляет на другую страницу
    document.getElementById('finishBtn').onclick = function() {
      window.location.href = 'index.php'; // Укажите здесь нужный URL
    };
  
    // Инициализация и открытие модального окна с помощью Bootstrap
    $('#dynamicModal').modal('show');
} 