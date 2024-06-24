function CatchButton(obj)
{
    let str1 = obj.id;
    let arr1 = str1.split('-');
    let str2 = obj.name;
    let arr2 = str2.split('-');
    if (arr2[0] == 1)
    {
        elemname="Большая";
        koef = parseFloat(arr2[1]);
    }
    if (arr2[0] == 2)
    {
        elemname="Средняя";
        koef = parseFloat(arr2[1]);
    }
    if (arr2[0] == 3)
    {
        elemname="Маленькая";
        koef = parseFloat(arr2[1]);
    }
    let table = document.getElementById("t1");
    let j = 0;
    for (i=1;i<table.rows.length;i++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[i].getElementsByTagName("input");
        col1 = column[1].value;
        col2 = column[2].value;
        if (col1==arr1[0] && col2==elemname)
        {
            col3 = column[3].value;
            column[3].value=parseInt(col3)+1;
            column[5].value=parseInt(parseInt(arr1[1]) * koef * parseInt(column[3].value));
            j=j+1;
        }
    }
    if(j==0)
    {
        let row = table.insertRow();
        let cell1 = row.insertCell();
        let cell2 = row.insertCell();
        let cell3 = row.insertCell();
        let cell4 = row.insertCell();
        let cell5 = row.insertCell();
        let cell6 = row.insertCell();
        let cell7 = row.insertCell();
        counter = table.rows.length - 1;
        cell1.innerHTML = `<input value="${counter}" class="tabletext" readonly="true" style="width: 25px;">`;
        cell2.innerHTML = `<input value="${arr1[0]}" class="tabletext" readonly="true" style="width: 105px;">`;
        cell3.innerHTML = `<input value="${elemname}" class="tabletext" readonly="true" style="width: 100px;">`;
        cell4.innerHTML = `<input value="1" class="tabletext" readonly="true" style="width: 90px;">`;
        cell5.innerHTML = `<input value="${parseInt(parseInt(arr1[1]) * koef)}" readonly="true" class="tabletext" style="width: 40px;">`;
        cell6.innerHTML = `<input value="${parseInt(parseInt(arr1[1])* koef * 1)}" readonly="true" class="tabletext" style="width: 80px;">`;  
        cell7.innerHTML = `<input type="button" id="${counter}" value="Удалить" class="btn3" style="width: 75px;" onclick="DeleteStr(this);">`;
    }
    let sum = 0;
    for(k=1;k<table.rows.length;k++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[k].getElementsByTagName("input");
        let stoim = column[5].value;
        sum = sum + parseInt(stoim);
        document.getElementById("itogo").value = sum;
    }
    for(l=1;l<table.rows.length;l++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[l].getElementsByTagName("input");
        column[1].setAttribute("name",`pizza${l}`);
        column[2].setAttribute("name",`size${l}`);
        column[3].setAttribute("name",`quantity${l}`);
    }       
}
function DeleteStr(obj)
{
    let table = document.getElementById("t1");
    let sum = 0;   
    table.deleteRow(obj.id); 
    for (i=1;i<table.rows.length;i++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[i].getElementsByTagName("input");
        let counter = i;
        column[0].value = counter;
        column[6].setAttribute("id", `${counter}`);
        let stoim = column[5].value;
        sum = sum + parseInt(stoim);
        document.getElementById("itogo").value = sum;
    }
    if (table.rows.length == 1)
    {
        document.getElementById("itogo").value = "";
    }
    for(l=1;l<table.rows.length;l++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[l].getElementsByTagName("input");
        column[1].setAttribute("name",`pizza${l}`);
        column[2].setAttribute("name",`size${l}`);
        column[3].setAttribute("name",`quantity${l}`);  
    }
}
function GetTime()
{
    let time = setInterval(function()
    {
        let date = new Date();
        let rightmonth = date.getMonth() + 1;
        let month = ("0" + rightmonth).slice(-2);
        let day = ("0" + (date.getDate())).slice(-2);
        let year = date.getFullYear();
        let hours = ("0" + (date.getHours())).slice(-2);
        let minutes = ("0" + (date.getMinutes())).slice(-2);
        document.getElementById("date").value = (day + "." + month + "." + year);
        document.getElementById("time").value = (hours + ":" + minutes); 
    }, 1000);
    let checkbox = document.getElementById("checkbox");
    if (checkbox.checked) 
    {
        document.getElementById("kupura").disabled = true;
        document.getElementById("kupura").placeholder = "";
    }
    else
    {
        document.getElementById("kupura").disabled = false;
        document.getElementById("kupura").placeholder = "С какой суммы сдача";
    }
}
function Search()
{
    let phrase = document.getElementById('tx');
    let table = document.getElementById('ta');
    let regPhrase = new RegExp(phrase.value, 'i');
    let flag = false;
    for(let i=1;i<table.rows.length;i++)
    {
        flag=false;
        for(let j=table.rows[i].cells.length-1;j>=0;j--)
        {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag)
        {
            table.rows[i].style.display = "";
        }
        else
        {
            table.rows[i].style.display = "none";
        }
    }
}
function GetDate()
{
    let date = new Date();
    let rightmonth = date.getMonth() + 1;
    let month = ("0" + rightmonth).slice(-2);
    let day = ("0" + (date.getDate())).slice(-2);
    let year = date.getFullYear();
    document.getElementById("tx").value = (year + "-" + month + "-" + day);
}
function SendDate()
{
    let idoperator = document.getElementById("link").name;
    let date = String(document.getElementById("tx").value);
    let arr = date.split('-');
    let year = arr[0];
    let month = arr[1];
    let day = arr[2];
    let strdate = day + '.' + month + '.' + year;
    let newlink = document.getElementById("link");
    newlink.setAttribute('href', `reportdoc.php?dateofreport=${strdate}&id_operator=${idoperator}`);
}
function CountSumSdachi()
{
    let sumorder = document.getElementById("itogo");
    let kupura = document.getElementById("kupura");
    let sdacha = document.getElementById("summasdachi");
    sdacha.value = String(Number(kupura.value) - Number(sumorder.value));
    if (Number(sumorder.value)==0 || Number(kupura.value) == 0) sdacha.value = "";
}
function DisableSdacha(event)
{
    elem = event.target;
    if (elem.type == "checkbox" && elem.checked == true)
    {
        document.getElementById("kupura").disabled = true;
        document.getElementById("kupura").placeholder = "";
    }
    if (elem.type == "checkbox" && elem.checked == false)
    {
        document.getElementById("kupura").disabled = false;
        document.getElementById("kupura").placeholder = "С какой суммы сдача";
    } 
}
$(document).ready(function() {
    var token = "997ca27622ab5986a2a9bce2969613d7506ecd46";
    var $city   = $("#city");
    var $street = $("#street");
    var $house  = $("#house");

    // город и населенный пункт
    $city.suggestions({
    token: token,
    type: "ADDRESS",
    hint: false,
    bounds: "city-settlement"
    });

    // улица
    $street.suggestions({
    token: token,
    type: "ADDRESS",
    hint: false,
    bounds: "street",
    constraints: $city
    });

    // дом
    $house.suggestions({
    token: token,
    type: "ADDRESS",
    hint: false,
    noSuggestionsHint: false,
    bounds: "house",
    constraints: $street
    });
});