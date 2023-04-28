<?php
require_once('require/db.php');

$queryIdCatalog = mysqli_query($db, "SELECT * FROM `catalog` ORDER BY `id` DESC");
$resultIdCatalog = mysqli_fetch_array($queryIdCatalog);

if(isset($_POST['submit'])){

    $markup = '0';
    $price = '0';

    $title = $_POST['title'];
    $brand = $_POST['brand'];
    $models = $_POST['models'];
    $price = $_POST['price'];
    $number = $_POST['number'];
    $date = date('Y-m-d');

    $markupValue = $_POST['markupValue']; // тип значения
    $markupType = $_POST['markup']; // значение наценки

    $suppliers = $_POST['suppliers'];

    // сумма 

    $article = date('dmy');

    if(empty($resultIdCatalog['id'])){
        $article = '0'.$article;
    }else{
        $article = $resultIdCatalog['id'].$article; 
    }

    $queryAddSuppliers = "INSERT INTO `catalog` 
    (`title`, `price`, `value_markup`, `type_markup`, `brand_car`, `model_car`, `suppliers`, `article`, `date`, `count`) VALUES 
    ('$title', '$price', '$markupType', '$markupValue', '$brand', '$models', '$suppliers', '$article', '$date', '$number')";
    $resultAddSuppliers = mysqli_query($db, $queryAddSuppliers) or die(mysqli_error($db));
   

}


?>

<?php require_once('require/header.php'); ?>


<link rel="stylesheet" href="css/purchase.css">

<section class="purchase">
    <div class="container">
        <div class="sectionTitle">
            <h2>Добавление автозапчастей</h2>
        </div>

        <div class="sectionContent">
            <form action="" method="post" class="formContent">
                
                <label for="" class="labelForm">
                    <p>Название автозапчасти</p>
                    <input type="text" class="inputForm" name="title" placeholder="Термостат" required>
                </label>
            
                <label for="" class="labelForm">
                    <p>Марка автомобиля</p>

                    <select size="1" name="brand" class="inputForm" onchange="javascript:selectBrand();" required>
                        <option disabled selected >Выберите марку</option>
                        <?php $queryCarBrand = mysqli_query($db, "SELECT DISTINCT `COL1` FROM `cars`");
                        while($rowCarBrand = mysqli_fetch_array($queryCarBrand)){?>
                            <option value="<?php echo $rowCarBrand['COL1']; ?>"><?php echo $rowCarBrand['COL1']; ?></option>
                        <?php } ?>
                    </select>

                    <div class="selectDataModels" name="selectDataModels"></div>
                </label>

                <label for="" class="labelForm">
                    <p>Цена поставщика</p>
                    <input type="text" class="inputForm" name="price" placeholder="Введите стоимость без НДС" required>
                </label>

                <label for="" class="labelForm">
                    <p>Наценка</p>
                    <input type="text" class="inputForm" name="markup" placeholder="Введите значение наценки" required>

                    <select name="markupValue" class="inputForm" id="" require>
                        <option disabled selected >Тип наценки</option>
                        <option value="rubles">Рубли</option>
                        <option value="percent">%</option>
                    </select>
                </label>


                <label for="" class="labelForm">
                    <p>Выбор поставщика</p>

                    <select name="suppliers"  class="inputForm" id="" require>
                    <?php $queryRow = mysqli_query($db, "SELECT * FROM `suppliers`");
                        while ($row = mysqli_fetch_array($queryRow)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['title_suppliers']; ?></option>
                        <?php } ?>
                    </select>
                </label>

                <label for="" class="labelForm">
                    <p>Кол-во приходящего товара</p>
                    <input type="number" class="inputForm" name="number" placeholder="Введите кол-во товара" required>
                </label>
                
                <input type="submit" class="submitForm" name="submit" value="Добавить">
            </form>
        </div>
    </div>
</section>

  
    
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