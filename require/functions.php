<?php

function markup($typeMarkup, $valueMarkup, $price){
    if($typeMarkup == 'rubles'){
        $valueMarkup = $price + $valueMarkup;
        return $valueMarkup." Руб.";
    }elseif($typeMarkup == 'percent'){
        $valueMarkup = $price*($valueMarkup+100)/100;
        return $valueMarkup." Руб.";
    }

}


?>