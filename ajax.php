<?php
require_once('require/db.php'); // подключаем файл с данными

$brand = $_POST['brand'];
echo '<select size="1" class="inputPurchase"  name="models">';
$queryCarBrand =  mysqli_query($db, "SELECT * FROM `cars` WHERE `COL1` = '$brand'");
while($rowCarBrand = mysqli_fetch_array($queryCarBrand)){
        echo '<option value="'.$rowCarBrand['COL7'].'">'.$rowCarBrand['COL7'].'</option>';
}
        
echo '</select>';
             


?>

