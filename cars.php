<?php
$arModels = array(
    'BMW' => array(
        0 => '1-series',
        1 => '2-series',
        2 => '3-series',
        // ...
    ),
    'Mercedes-Benz' => array(
        0 => 'A-класс',
        1 => 'B-класс',
        2 => 'C-класс',
        // ...
    ),
    // и т.д.
);

$arModels = array(); // make a new array to hold all your data


$index = 0;

    $queryCarBrand =  mysqli_query($db, "SELECT * FROM `cars` WHERE `COL1` = 'AC'");
while($row = mysql_fetch_assoc($result)){ // loop to store the data in an associative array.
     $yourArray[$index] = $row;
     $index++;
}
?>