<?php
require_once('require/header.php');
require_once('require/functions.php');

$cookieLogin = $_COOKIE['login'];

if(isset($_GET['addBasket'])){
    $addBasket = $_GET['addBasket'];

    $queryBasket = mysqli_query($db, "SELECT * FROM `basket` WHERE `id_trade` = '$addBasket' AND `seller` = '$cookieLogin'");
    $resultBasket = mysqli_fetch_array($queryBasket);

    $queryCatalog = mysqli_query($db, "SELECT * FROM `catalog` WHERE `id` = '$addBasket'");
    $resultCatalog = mysqli_fetch_array($queryCatalog);

    if(!empty($resultBasket)){
        if($resultCatalog['count'] == $resultBasket['count']){
            exit('Ошибка предельно кол-во товара');
        }else{
            $queryBasketAddCount = mysqli_query($db, "UPDATE `basket` SET `count`=`count` + '1' WHERE `id_trade` = '$addBasket'");
        }
    }else{
         $title = $resultCatalog['title'];
        $price = markup($resultCatalog['type_markup'], $resultCatalog['value_markup'], $resultCatalog['price']);
        $price = (int)$price;
        $count = '1';
        $seller = $cookieLogin;

        $queryAddBasket = "INSERT INTO `basket` (`title`, `price`, `count`, `seller`, `id_trade`) VALUES ('$title', '$price', '$count', '$seller', '$addBasket')";
        $resultAddBasket = mysqli_query($db, $queryAddBasket) or die(mysqli_error($db));

        header('Location: cheque.php');
        exit;
    }

}


if(isset($_GET['chequeDeleteItem'])){
    $idChequeDeleteItem = $_GET['chequeDeleteItem'];

    $queryDelete = mysqli_query($db, "DELETE FROM `basket` WHERE `id` = '$idChequeDeleteItem' ");
    header('Location: cheque.php');
    exit;
}

$queryBasket = mysqli_query($db, "SELECT * FROM `basket` WHERE `seller` = '$cookieLogin'");
$resultBasket = mysqli_fetch_array($queryBasket);


$queryCheque = mysqli_query($db, "SELECT * FROM `cheque` ORDER BY `id` DESC");
$resultCheque = mysqli_fetch_array($queryCheque);


if(isset($_POST['submit'])){
    $idProduct = $_POST['idProduct'];
    $titleProduct = $_POST['titleProduct'];
    $price = $_POST['price'];
    $count = $_POST['count'];
    $date = date('Y-m-d');


    if($resultCheque == null){
        $idCheque = 0;
    }else{
        $idCheque = $resultCheque['id'];
    }

    $idCheque += 1;
    
    // формирование заголовка

    $title = "Чек №".$idCheque."-".$date;

    for ($i=0; $i < count($titleProduct); $i++) {
        $totalPrice = $price[$i] * $count[$i];

        $queryAddCheque = "INSERT INTO `cheque` (`title`, `seller`, `total_price`, `date`) 
        VALUES ('$title', '$cookieLogin', '$totalPrice','$date')";
        $resultAddCheque = mysqli_query($db, $queryAddCheque) or die(mysqli_error($db));
    
        $queryAddChequeInfo = "INSERT INTO `cheque_info` (`title_product`, `price`, `count`, `id_cheque`) 
        VALUES ('$titleProduct[$i]', '$price[$i]', '$count[$i]', '$idCheque')";
        $resultAddChequeInfo = mysqli_query($db, $queryAddChequeInfo) or die(mysqli_error($db));

        $queryBasketAddCount = mysqli_query($db, "UPDATE `catalog` SET `count` = `count` - $count[$i] WHERE `id` = '$idProduct[$i]'");

        // Удаление таблицы с формированием чека 

        $queryDelete = mysqli_query($db, "DELETE FROM `basket` WHERE `seller` = '$cookieLogin'");


        header('Location: cheque.php');
        exit;
    }

}



?>

<link rel="stylesheet" href="css/suppliers.css">

<section class="cheque">
    <div class="container">
        <?php
        if(!empty($resultBasket)){
        ?>
            <div class="sectionTitle">
                <h2>Формирование чеков</h2>
            </div>

            <div class="sectionContent">
                <form action="" method="post">
                    <table>
                        <tr>
                            <th>Наименование</th>
                            <th>Сумма</th>
                            <th>Кол-во</th>
                            <th>Продавец</th>
                            <th>Действия</th>
                        </tr>
                    <?php 
                    $queryRow = mysqli_query($db, "SELECT * FROM `basket` WHERE `seller` = '$cookieLogin' ORDER BY `id` DESC");
                    while ($row = mysqli_fetch_array($queryRow)) { 
                        $idTrade = $row['id_trade'];
                        $queryCount = mysqli_query($db, "SELECT * FROM `catalog` WHERE `id` = '$idTrade'");
                        $resultCount = mysqli_fetch_array($queryCount);
                        ?>
                            <tr>
                            <input type="text" style="display: none;" name="idProduct[]" value="<?php echo $resultCount['id']; ?>" id="" readonly>

                                <td><input type="text" name="titleProduct[]" value="<?php echo $row['title']; ?>" id="" readonly></td>
                                <td><input type="text" name="price[]" value="<?php echo $row['price']; ?>" id="" readonly></td>
                                <td>
                                    <input type="number" name="count[]" min="0" max="<?php echo $resultCount['count']; ?>" value="<?php echo $row['count']; ?>">
                                </td>
                                <td><input type="text" name="seller[]" value="<?php echo $row['seller']; ?>" id="" readonly></td>
                                <td><a href="cheque.php?chequeDeleteItem=<?php echo $row['id']; ?>" class="action">Удалить</a></td>
                            </tr>
                    <?php } ?>
                    </table>

                    <input type="submit" name="submit" class="submitForm" value="Сформировать чек">
                    <a class="removeBtn" href="cheque.php?chequeRemoveLogin=<?php echo $cookieLogin; ?>">Сбросить чек</a>
                </form>
            </div>
        <?php 
        }
        ?>

        <div class="sectionTitle">
            <h2>Чеки</h2>
        </div>

        <div class="sectionContent">

        <table>
            <tr>
                <th>Наименование</th>
                <th>Сумма</th>
                <th>Продавец</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            <?php 
            $queryRow = mysqli_query($db, "SELECT * FROM `cheque` ORDER BY id DESC");
            while ($row = mysqli_fetch_array($queryRow)) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['seller']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><a href="" class="action">Скачать</a></td>
                    </tr>
            <?php }
            
            ?>
            </table>
        </div>
    </div>
</section>
</body>
</html>

