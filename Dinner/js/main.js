var arr_date = [];
var counter = 0;
var category = [];
var data = {};

function GetEmployees()
{
    
    workers.sort((a,b) => a.full_name > b.full_name ? 1 : -1);
    let table = document.getElementById("worker-table");
    let counter;
    workers.forEach((user) => {
        counter++;
        let row = table.insertRow();
        let cell1 = row.insertCell();
        let cell2 = row.insertCell();
        let cell3 = row.insertCell();
        counter = table.rows.length - 1;
        cell1.innerHTML = counter;
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
    counter++;
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
}
function RememberFilling()
{
    GetData();
    console.log(data);
    ShowDate();
    document.querySelectorAll(".form-control").forEach(ta => {
        ta.value = "";
    });
}
function CheckFilling()
{
    GetData();
    console.log(data);
    let table = document.createElement("table");
    table.className = "table table-hover";
    let thead = document.createElement('thead');
    let trHead = document.createElement('tr');
    let thCategory = document.createElement('th');
    let thDish = document.createElement('th');
    let thPrice = document.createElement('th');
    thCategory.scope = 'col';
    thCategory.textContent = 'Категория';
    thDish.scope = 'col';
    thDish.textContent = 'Блюдо';
    thPrice.scope = 'col';
    thPrice.textContent = 'Цена';
    trHead.appendChild(thCategory);
    trHead.appendChild(thDish);
    trHead.appendChild(thPrice);
    thead.appendChild(trHead);
    var details = document.querySelectorAll(".choose-food__form__details");
    details.forEach(de => {
        text_node = de.childNodes[3].childNodes[1];
        price_node = de.childNodes[3].childNodes[3];
        if (text_node.value !== "" && price_node.value !== "")
        {
            price_node.remove();
            text_node.remove();
            de.childNodes[3].innerHTML = 
            `<table class="table table-hover" id="worker-table">
            <thead>
              <tr>
                <th scope="col">Категория</th>
                <th scope="col">Блюдо</th>
                <th scope="col">Цена</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>;`
        }
    });
    
}  