<?php require_once('require/header.php'); ?>

<?php 
require_once('require/db.php');

if(isset($_POST['submit'])){
    $title_suppliers = $_POST['title'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $location = $_POST['location'];

    $queryAddSuppliers = "INSERT INTO `suppliers` (`title_suppliers`, `email`, `tel`, `location`) VALUES ('$title', '$email', '$tel', '$location')";
    $resultAddSuppliers = mysqli_query($db, $queryAddSuppliers) or die(mysqli_error($db));
    header('Location: suppliers.php');
    exit;
}

?>


<link rel="stylesheet" href="css/suppliers.css">

<section class="suppliers">
    <div class="container">
        <div class="sectionTitle">
            <h2>Добавление поставщиков</h2>
        </div>

        <div class="sectionContent">
            <form action="" method="post" class="formContent"> 

                <label for="" class="labelForm">
                    <p>Юридическое название организации-поставщика</p>

                    <input type="text" class="inputForm" name="title" placeholder='ООО "Организация"'>
                </label>

                <label for="" class="labelForm">
                    <p>E-mail поставщика</p>

                <input type="text"  class="inputForm"  name="email" placeholder="test@yandex.ru">
                </label>

                <label for="" class="labelForm">
                    <p>Телефон поставщика</p>

                    <input type="text" class="inputForm"  name="tel" placeholder="+7(904) 298 83-62">
                </label>

                <label for="" class="labelForm">
                    <p>Юридический адрес организации</p>

                    <input type="text" class="inputForm"  name="location" placeholder="г.Воронеж..">
                </label>



                <input type="submit" class="submitForm"  name="submit" value="Добавить поставщика">
            </form>
        </div>

        <div class="sectionTitle">
            <h2>Все поставщики</h2>
        </div>

        <div class="sectionContent">

        <table border="1">
            <tr>
                <th>Юр.название организации</th>
                <th>E-mail поставщика</th>
                <th>Телефон поставщика</th>
                <th>Юр.адрес организации</th>
                <th>Действия</th>
            </tr>
            <?php 
            $queryRow = mysqli_query($db, "SELECT * FROM `suppliers` ORDER BY `id` DESC");
            while ($row = mysqli_fetch_array($queryRow)) { ?>
                    <tr>
                        <td><?php echo $row['title_suppliers']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['tel']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><a href="" class="action"><img src="img/edit.png" alt=""> Редактировать</a>
                            <a href="" class="action"><img src="img/delete.png" alt=""> Удалить</a></td>
                    </tr>
            <?php }
            
            ?>
            </table>
        </div>
    </div>
</section>
</body>
</html>