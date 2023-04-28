<?php 
require_once('require/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

    <title>Document</title>
</head>
<body>

    
<select size="1" name="brand" onchange="javascript:selectBrand();" style="float:left;">
    <optgroup label="Выберите марку">
    <?php

$queryCarBrand =  mysqli_query($db, "SELECT DISTINCT `COL1` FROM `cars`");
while($rowCarBrand = mysqli_fetch_array($queryCarBrand)){?>
    <option value="<?php echo $rowCarBrand['COL1']; ?>"><?php echo $rowCarBrand['COL1']; ?></option>
    <?php
    }
?>
    </optgroup>
</select>

<div name="selectDataModels" style="float:left;"></div>

  
    <script>
   function selectBrand(){
        var brand = $('select[name="brand"]').val();
        if(!brand){
                $('div[name="selectDataModels"]').html('');
        }else{
                $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: { action: 'showRegionForInsert', brand: brand },
                        cache: false,
                        success: function(responce){ $('div[name="selectDataModels"]').html(responce); }
                });
        };
};

    </script>
</body>
</html>