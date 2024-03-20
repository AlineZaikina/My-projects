window.addEventListener('DOMContentLoaded', () => {
    let counter;
    let container = document.querySelector('.container');
    container.innerHTML = `
        <div class="move-buttons">
            <button class="move-buttons__item" id="create">add</button>
            <button class="move-buttons__item" id="edit">edit</button>
            <button class="move-buttons__item" id="delete">del</button>
        </div>
        <div class="left-box">
            <h2 class="text-h2">Available</h2>
            <div class="left-box__header">
                <input type="text" class="left-box__input" placeholder="Поиск...">
                <button class="left-box__sort-button">Автосортировка</button>
            </div>
        </div>
        <div class="move-buttons">
            <button class="move-buttons__item add" id="add">></button>
            <button class="move-buttons__item addall" id="addall">>></button>
            <button class="move-buttons__item remove" id="remove"><</button>
            <button class="move-buttons__item removeall" id="removeall"><<</button>
        </div>
        <div class="right-box">
            <h2 class="text-h2">Selected</h2>
            <div class="right-box__header">
                <input type="text" class="right-box__input" placeholder="Поиск...">
                <button class="right-box__sort-button">Автосортировка</button>
            </div>
        </div>
    `;
    let left_box = document.querySelector('.left-box');
    for (counter = 1;counter <= 10; counter++)
    {
        let div = document.createElement('div');
        div.className = "left-box__item";
        div.id = `${counter}`;
        div.draggable = true;
        div.textContent = `${counter}`;
        left_box.appendChild(div);
    }
    let div = document.createElement('div');
    div.className = "group-of-buttons";
    div.innerHTML = 
    `<button class="group-of-buttons__item" id="generate">Сгенерировать случайные значения</button>
     <button class="group-of-buttons__item" id="reset">Сброс всех изменений</button>
     `;
    document.body.append(div);

    (function () {
        let arr = [];
        let right_box = document.querySelector('.right-box');
        function HandleClick(event) {
            if (event.target.classList.contains("left-box__item")) {
                event.target.classList.toggle("selected-item");
                const found = arr.find((item) => Number(item.id) === Number(event.target.id));
                if (found) {
                    arr = arr.filter((item) => Number(item.id) !== Number(event.target.id));
                } else {
                    arr.push(event.target);
                }            
            }
        }
    
        left_box.addEventListener("click", HandleClick);
        right_box.addEventListener("click", HandleClick);
    
        function HandleMove(event) {
            const target = event.target;
            if (target.classList.contains("add")) {
                arr.forEach((item) => {
                    if (item.parentElement === left_box) {
                    right_box.appendChild(left_box.removeChild(item));
                    item.classList.remove("selected-item");
                    }
                });
                arr = [];
                
            } else if (target.classList.contains("removeall")) {
                Array.from(right_box.querySelectorAll(".left-box__item")).forEach((item) => {
                    left_box.appendChild(right_box.removeChild(item));
                    item.classList.remove("selected-item");
                });
                arr = [];
            } else if (target.classList.contains("addall")) {
                Array.from(left_box.querySelectorAll(".left-box__item")).forEach((item) => {
                    right_box.appendChild(left_box.removeChild(item));
                    item.classList.remove("selected-item");
                });
                arr = [];
            } else if (target.classList.contains("remove")) {
                arr.forEach((item) => {
                    if (item.parentElement === right_box) {
                        left_box.appendChild(right_box.removeChild(item));
                        item.classList.remove("selected-item");
                    }                
                });
                arr = [];
            }
        } 
        document.getElementById('remove').addEventListener("click", HandleMove);
        document.getElementById('add').addEventListener("click", HandleMove);
        document.getElementById('removeall').addEventListener("click", HandleMove);
        document.getElementById('addall').addEventListener("click", HandleMove);   
    
        function SearchElem()
        {
            let val = this.value;
            let elements = [];
            if (this.classList.contains("left-box__input")) {
                elements = Array.from(left_box.querySelectorAll('.left-box__item'));
            }
            else {
                elements = Array.from(right_box.querySelectorAll('.left-box__item'));
            }
            if (val != '') {
                elements.forEach(function(elem) {
                    if (elem.innerText.search(val) == -1) {
                        elem.classList.add('hide');
                    }
                    else {
                        elem.classList.remove('hide');
                    }
                });
            }
            else {
                elements.forEach(function(elem) {
                    elem.classList.remove('hide');
                });
            }
        }
        document.querySelector('.left-box__input').addEventListener("input", SearchElem);
        document.querySelector('.right-box__input').addEventListener("input", SearchElem);
    
        let dragelem;
        function OnDragStart(event)
        {
            dragelem = event.target;
        }
        function OnDrop(event)
        {
            let targetelem = event.target;
            targetelem.parentElement.insertBefore(dragelem, targetelem);
        }
        function OnDragOver(event)
        {
            event.preventDefault();
        }
        left_box.addEventListener("dragstart", OnDragStart);
        left_box.addEventListener("drop", OnDrop);
        left_box.addEventListener("dragover", OnDragOver)
        right_box.addEventListener("dragstart", OnDragStart);
        right_box.addEventListener("drop", OnDrop);
        right_box.addEventListener("dragover", OnDragOver)
    
        function AutoSort()
        {
            let sortarr = [];
            let box;
            if (this.classList.contains("left-box__sort-button")) {
                sortarr = Array.from(left_box.querySelectorAll('.left-box__item'));
                box = left_box
            }
            else {
                sortarr = Array.from(right_box.querySelectorAll('.left-box__item'));
                box = right_box;
            }
            sortarr.sort(function(a,b) {
                if (isNaN(Number(a.textContent)))
                {
                    if (a.textContent > b.textContent) return 1;
                    if(a.textContent < b.textContent) return -1;
                    else return 0;
                }
                else
                {
                    if(Number(a.textContent) > Number(b.textContent)) return 1;
                    if(Number(a.textContent) < Number(b.textContent)) return -1;
                    else return 0;
                }
            });
            while (box.querySelector('.left-box__item')) {
                box.removeChild(box.querySelector('.left-box__item'));
            }
            sortarr.forEach(function(elem) {
                box.appendChild(elem);
            });
        }
        document.querySelector('.left-box__sort-button').addEventListener("click", AutoSort);
        document.querySelector('.right-box__sort-button').addEventListener("click", AutoSort);

        function CreateNewElement()
        {
            let div = document.createElement('div');
            div.className = "left-box__item";
            div.id = `${counter}`;
            div.draggable = true;
            div.textContent = prompt("Заполните название нового элемента");
            if (div.textContent != '') left_box.appendChild(div);
            else alert("Вы не заполнили название элемента, поэтому не можете его создать!");
            counter++;
        }
        function EditElement()
        {
            arr=[];
            left_box.querySelectorAll('.left-box__item').forEach(function(elem) {
                if (elem.classList.contains("selected-item"))
                {
                    arr.push(elem);
                }
            });
            if (arr.length > 1) alert("Выберите только один элемент для редактирования!");
            else if (arr.length == 0) alert ("Выберите элемент для редактирования!");
            else {
                document.querySelector(".selected-item").textContent = prompt("Отредактируйте значение", arr[0].textContent); 
            }    
        }
        function DeleteElement()
        {
            arr = [];
            let delelem;
            left_box.querySelectorAll('.left-box__item').forEach(function(elem) {
                if (elem.classList.contains("selected-item"))
                {
                    arr.push(elem);
                }
            });
            if (arr.length == 0) alert ("Выберите хотя бы один элемент для удаления!");
            else delelem = confirm("Вы уверены, что хотите удалить эти элементы?");
            if (delelem)
            {
                arr.forEach(function(item) {
                    left_box.removeChild(item)
                });  
            }
        }
        document.getElementById("create").addEventListener("click", CreateNewElement);
        document.getElementById("edit").addEventListener("click", EditElement);
        document.getElementById("delete").addEventListener("click", DeleteElement);

        function ResetElements()
        {
            left_box.querySelectorAll('.left-box__item').forEach(function(elem) {
                left_box.removeChild(elem);
            });
            right_box.querySelectorAll('.left-box__item').forEach(function(elem) {
                right_box.removeChild(elem);
            });
            for (counter = 1;counter <= 10; counter++)
            {
                let div = document.createElement('div');
                div.className = "left-box__item";
                div.id = `${counter}`;
                div.draggable = true;
                div.textContent = `${counter}`;
                left_box.appendChild(div);
            }
        }
        function GenerateElements()
        {
            let randomstring = '';
            const letters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            left_box.querySelectorAll('.left-box__item').forEach(function(elem) {
                for (let i = 0; i <= 7; i++)
                {
                    randomstring += letters.charAt(Math.floor(Math.random() * letters.length));
                }
                elem.textContent = randomstring;
                randomstring = '';
            });
        }
        document.getElementById("reset").addEventListener("click", ResetElements);
        document.getElementById("generate").addEventListener("click", GenerateElements);
    })()
})
