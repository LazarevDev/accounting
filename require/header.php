<?php
require_once('db.php');

$cookieLogin = $_COOKIE['login'];

$queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$cookieLogin'");
$resultStaff = mysqli_fetch_array($queryStaff);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Document</title>
</head>
<body>

<script>
//     var loading = {
//   start: function() {
//     document.body.insertAdjacentHTML('beforeend', '<div class="loading" id="loading"><img src="https://icons8.com/icon/kSPAlL1vFDfX/spinning-circle"></div>');
//   },
//   complete: function() {
//     var loading = document.getElementById("loading");
//     console.log(loading);
//     loading.remove(loading);
//   }
// };
// loading.start();
// document.addEventListener("readystatechange", function() {
//   console.log(document.readyState);
//   if (document.readyState === "complete") {
//     loading.complete();
//   }
// });
</script>


    <header>
        <div class="container">
            <div class="headerContent">
                <ul class="menu">
                    <li><a class="menuItem" href="index.php"><img src="../img/graph.png" alt=""><p>Главная</p></a></li>
                    <li><a class="menuItem" href="suppliers.php"><img src="../img/supplier.png" alt=""><p>Поставщики</p></a></li>
                    <li><a class="menuItem" href="purchase.php"><img src="../img/transit.png" alt=""><p>Закупки</p></a></li>
                    <li><a class="menuItem" href="catalog.php"><img src="../img/discs.png" alt=""><p>Товары</p></a></li>
                    <li><a class="menuItem" href="cheque.php"><img src="../img/cheque.png" alt=""><p>Продажи</p></a></li>
                
                    <?php 
                    if($resultStaff['role'] == '1'){ ?>
                        <li><a class="menuItem" href="staff.php"><img src="../img/staff.png" alt=""><p>Сотрудники</p></a></li>
                    <?php } ?>
                
                </ul>

                <a href="../logout.php" class="userProfile menuItem">
                    <img src="../img/user.png" alt="">
                    <p>Выход</p>
                </a>
            </div>
        </div>
    </header>
