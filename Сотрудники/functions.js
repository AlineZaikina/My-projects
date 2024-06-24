function AddString()
{
    let table = document.getElementById("table1");
    let counter = table.rows.length;
    let row = table.insertRow();
    let cell1 = row.insertCell();
    let cell2 = row.insertCell();
    let cell3 = row.insertCell();
    let cell4 = row.insertCell();
    let cell5 = row.insertCell();
    cell1.innerHTML = counter;
    cell2.innerHTML = `<input type="date" class="noborder" name="datebeg${counter}">`;
    cell3.innerHTML = `<input type="date" class="noborder" name="dateend${counter}">`;
    cell4.innerHTML = `<input class="border_bottom" name="place${counter}">`;
    cell5.innerHTML = `<input type="button" id="${counter}" value="Удалить" class="btn btn-outline-secondary" onclick="DeleteStr(this);">`;
    for (i=1;i<table.rows.length;i++)
        {
            let line = table.getElementsByTagName("tr");
            let column = line[i].getElementsByTagName("td");
            let counter = i;
            column[0].innerHTML = counter;
            let cell = line[i].getElementsByTagName("input");
            cell[3].setAttribute("id", `${counter}`);
            cell[0].setAttribute("name",`datebeg${counter}`);
            cell[1].setAttribute("name",`dateend${counter}`);
            cell[2].setAttribute("name",`place${counter}`);
        }
    
}
document.getElementById("add-string").addEventListener("click",AddString);
function DeleteStr(obj)
{
    let table = document.getElementById("table1");
    table.deleteRow(obj.id);
    for (i=1;i<table.rows.length;i++)
    {
        let line = table.getElementsByTagName("tr");
        let column = line[i].getElementsByTagName("td");
        let counter = i;
        column[0].innerHTML = counter;
        let cell = line[i].getElementsByTagName("input");
        cell[3].setAttribute("id", `${counter}`);
        cell[0].setAttribute("name",`datebeg${counter}`);
        cell[1].setAttribute("name",`dateend${counter}`);
        cell[2].setAttribute("name",`place${counter}`);
    }
}