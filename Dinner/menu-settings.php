<?php 
require_once("header.php"); 
?> 
    <section class="body"> 
        <form method="post" action="" class="menu-settins__form"> 
            <div class="btn-group menu-settins__form__group"> 
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                  Для кого формировать 
                </button> 
                <div class="dropdown-menu"> 
                  <a class="dropdown-item" href="#">Все комнаты</a> 
                  <a class="dropdown-item" href="worker-list.php">Список сотрудников</a> 
                </div> 
            </div> 
            <div class="form-group menu-settins__form__last-day"> 
                <label for="exampleInputEmail1">Крайний срок сдачи</label> 
                <input type="datetime-local" class="form-control menu-settins__form__input" id="exampleInputEmail1" aria-describedby="emailHelp"> 
            </div> 
            <label for="menu-settins__form__group-input">Меню на даты</label> 
            <div class="form-group  menu-settins__form__group-input" id="menu-settins__form__group-input"> 
                <label for="exampleInputEmail1">от</label> 
                <input type="date" class="form-control menu-settins__form__input" id="first_date" aria-describedby="emailHelp" name="first_date"> 
                <label for="exampleInputEmail1">до</label> 
                <input type="date" class="form-control menu-settins__form__input" id="last_date" aria-describedby="emailHelp" name="last_date"> 
            </div> 
            <?php 

            ?> 
            <input class="btn btn-primary" type="button" value="Заполнить меню" id="fillMenu">
        </form> 
    </section> 
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        document.getElementById("fillMenu").onclick = GetDate;
    </script>
</body>
</html>