<?php 
// require_once('require/db.php');
require_once('require/header.php');


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $login = $_POST['login'];
    $salary = $_POST['salary'];
    $percentage_sale = $_POST['percentage_sale'];
    $password = $_POST['password'];
    
    $queryAddStaff = "INSERT INTO `staff` (`name`, `login`, `salary`, `percentage_sale`, `password`) VALUES 
    ('$name', '$login', '$salary', '$percentage_sale', '$password')";
    $resultAddStaff = mysqli_query($db, $queryAddStaff) or die(mysqli_error($db));

    header('Location: index.php');
    exit;



}




?>


<link rel="stylesheet" href="css/suppliers.css">

<section class="catalog">
    <div class="container">
    <div class="sectionTitle">
            <h2>Добавление сотрудников</h2>
        </div>

        <div class="sectionContent">
            <form action="" method="post" class="formContent"> 

                <label for="" class="labelForm">
                    <p>Фамилия имя</p>

                    <input type="text" class="inputForm" name="name" placeholder='Иванов Иван'>
                </label>

                <label for="" class="labelForm">
                    <p>Логин</p>

                <input type="text" class="inputForm" name="login" placeholder="ivan">
                </label>

                <label for="" class="labelForm">
                    <p>Фиксированная заработная плата сотрудника в месяц</p>

                    <input type="text" class="inputForm" name="salary" placeholder="10000">
                </label>

                <label for="" class="labelForm">
                    <p>Процент от проданного товара</p>

                    <input type="text" class="inputForm" name="percentage_sale" placeholder="6">
                </label>

                <label for="" class="labelForm">
                    <p>Пароль личного кабинета сотрудника</p>

                    <input type="password" class="inputForm" name="password" placeholder="Пароль">
                </label>



                <input type="submit" class="submitForm" name="submit" value="Добавить сотрудника">
            </form>
        </div>

        <div class="sectionTitle">
            <h2>Сотрудники</h2>
        </div>

        <div class="sectionContent">
        <table border="1">
            <tr>
                <th>Фамилия имя</th>
                <th>Логин</th>
                <th>Зарплата</th>
                <th>Процент с продажи</th>
                <th>Должность</th>
                <th>Действия</th>
            </tr>
            <?php 
            $queryRow = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` != 'root' ORDER BY `id` DESC");
            while ($row = mysqli_fetch_array($queryRow)) { 
    
                ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['login']; ?></td>
                        <td><?php echo $row['salary']."Руб."; ?></td>
                        <td><?php echo $row['percentage_sale']."%"; ?></td>
                        <td><?php if($row['role'] == '0'){ echo "Продавец"; } ?></td>
                        <td><a href="" class="action"><img src="img/edit.png" alt=""> Редактировать</a>
                            <a href="" class="action"><img src="img/delete.png" alt=""> Удалить</a></td>
                    </tr>
            <?php }
            
            ?>
            </table>
        </div>
    </div>
</section>