<?php
require_once('require/db.php');

if(isset($_POST['submit'])){
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$login' and `password` = '$password'");
    $result = mysqli_fetch_array($query);

    if(!empty($result)){
        setcookie('login', $login);
        setcookie('password', $password);

        header('Location: index.php');
        exit;
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <h2>Вход</h2>
        <input type="text" name="login" placeholder="Введите логин"><br>
        <input type="password" name="password" placeholder="Введите пароль"><br>
        <input type="submit" name="submit" value="Войти">
    </form>
</body>
</html>