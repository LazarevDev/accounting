<?php require_once('require/db.php'); ?>
<?php require_once('require/header.php');


require_once('require/functions.php');

?>





<link rel="stylesheet" href="css/suppliers.css">

<section class="catalog">
    <div class="container">
        <div class="sectionTitle">
            <h2>Все автозапчасти</h2>
        </div>

        <div class="sectionContent">

        <table border="1">
            <tr>
                <th>Название</th>
                <th>Цена поставщика</th>
                <th>Цена</th>
                <th>Марка/модель</th>
                <th>Поставщик</th>
                <th>Артикул</th>
                <th>Кол-во/шт</th>
                <th>Дата завоза</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            <?php 
            $queryRow = mysqli_query($db, "SELECT * FROM `catalog` ORDER BY `id` DESC");
            while ($row = mysqli_fetch_array($queryRow)) { 
                $suppliersId = $row['suppliers'];
                $querySuppliers = mysqli_query($db, "SELECT * FROM `suppliers` WHERE `id` = $suppliersId");
                $queryResultSuppliers = mysqli_fetch_array($querySuppliers);
                ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo markup($row['type_markup'], $row['value_markup'], $row['price']); ?></td>
                        <td><?php echo $row['brand_car']."/".$row['model_car']; ?></td>
                        <td><?php echo $queryResultSuppliers['title_suppliers']; ?></td>
                        <td><?php echo $row['article']; ?></td>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td>
                            <?php if($row['count'] > 0){ ?>
                                <div class="statusBlock inStock">
                                    <p>В наличии</p>
                                </div>
                            <?php }else{ ?>
                                <div class="statusBlock outStock">
                                    <p>Нет в наличии</p>
                                </div>
                            <?php } ?>
                        </td>

                        <td>
                            <a href="cheque.php?addBasket=<?php echo $row['id']; ?>" class="action"><img src="img/cheque-trade.png" alt=""></a>
                            <a href="" class="action"><img src="img/edit.png" alt=""></a>
                            <a href="" class="action"><img src="img/delete.png" alt=""></a>
                        </td>
                    </tr>
            <?php }
            
            ?>
            </table>
        </div>
    </div>
</section>