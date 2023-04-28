<?php 
require_once('require/header.php'); 
// require_once('require/db.php'); 

$loginCookie = $_COOKIE['login'];



function functionMonth($countMonth, $db, $loginCookie){

    $date = date('Y-m-d');

    if($countMonth == 3){
        $month = date('Y-m-1', strtotime($date. " - 3 month"));
        $monthMax = $date;
        $countM = 3;
    }elseif($countMonth == 2){
        $month = date('Y-m-1', strtotime($date. " - 1 month"));
        $monthMax = $date;
        $countM = 1;

    }elseif($countMonth == 1){
        $month = date('Y-m-1', strtotime($date. " - 2 month"));
        $monthMax = date('Y-m-1', strtotime($date. " - 1 month"));
        $countM = 1;

    }elseif($countMonth == 0){
        $month = date('Y-m-1', strtotime($date. " - 3 month"));
        $monthMax = date('Y-m-1', strtotime($date. " - 2 month"));
        $countM = 1;
    }
    

    $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$loginCookie'");
    $resultStaff = mysqli_fetch_array($queryStaff);

    $queryCheque = mysqli_query($db, "SELECT SUM(`total_price`) `total_price` FROM `cheque` WHERE `date` >= '$month' AND `date` <= '$monthMax'");
    $resultCheque = mysqli_fetch_array($queryCheque);

    $querySumCatalog = mysqli_query($db, "SELECT SUM(`price`) `price` FROM `catalog` WHERE `date` >= '$month' AND `date` <= '$monthMax'");
    $resultSumCatalog = mysqli_fetch_array($querySumCatalog);


    $querySale = mysqli_query($db, "SELECT * FROM `cheque` WHERE `date` >= '$month' AND `date` <= '$monthMax'");
    while($rowSale = mysqli_fetch_assoc($querySale)){
        $rowLogin = $rowSale['seller'];

        $queryStaff = mysqli_query($db, "SELECT * FROM `staff` WHERE `login` = '$rowLogin'");
        while($rowStaff = mysqli_fetch_assoc($queryStaff)){
            $percentageSale = $rowStaff['percentage_sale'];    
            $salary = $rowStaff['salary'];
        }
        $salarySale[] = $salary; 
        $sumSale[] = ($percentageSale * $rowSale['total_price'])/100;
    }

    if(empty($salarySale)){
        $salarySale = 0;
    }else{
        $sumSalary = array_sum($salarySale);
        $sumSalary = $sumSalary * $countM;
    }

    if(empty($sumSale)){
        $sumSale = 0;
    }else{
        $sumSale = array_sum($sumSale);
        $sumSale = intval($sumSale);
    }

    $sumStaff = $sumSale + $sumSalary;

    // Оборот продаж
    $turnover = $resultCheque['total_price'] + $resultSumCatalog['price'] + $sumStaff;

    // чистая прибыль
    $netProfit = $resultCheque['total_price'] - ($resultSumCatalog['price'] + $sumStaff);

    // создаем массив и выводим вне функции
    $resultSumCatalog = $resultSumCatalog['price'];
    return $stat = ['sumStaff' => $sumStaff, 'turnover' => $turnover, 'netProfit' => $netProfit, 'resultSumCatalog' => $resultSumCatalog]; 
}


$firstMonth = functionMonth(0, $db, $loginCookie)['turnover'];
$secondMonth = functionMonth(1, $db, $loginCookie)['turnover'];
$thirdMonth = functionMonth(2, $db, $loginCookie)['turnover'];

$totalSum = functionMonth(3, $db, $loginCookie)['turnover'];

function calculatingPercentages($month, $totalValue){
    $percentageAmount = ($month * 100)/$totalValue;
    $percentageAmount = (int)$percentageAmount;
    return $percentageAmount;
}


?>

<link rel="stylesheet" href="css/index.css">

<section>
    <div class="container">
        <div class="sectionTitle">
            <h2>Статистика за квартал</h2>
        </div>

        <div class="sectionContent">

            <div class="contentPrice">
                <div class="priceBlock">
                    <p>Оборот</p>
                    <h2><?php 
                        echo number_format(functionMonth(3, $db, $loginCookie)['turnover'])." Руб.";
                    ?></h2>

                    <hr>

                    <div class="priceBlockBottom">
                        <h3>Расходы на запчасти - <?php echo number_format(functionMonth(3, $db, $loginCookie)['resultSumCatalog'])." Руб."; ?></h3>
                        <h3>Расходы на сотрудников - <?php echo number_format(functionMonth(3, $db, $loginCookie)['sumStaff'])." Руб."; ?></h3>
                        <h3>Чистая прибыль - <?php echo number_format(functionMonth(3, $db, $loginCookie)['netProfit'])." Руб."; ?></h3>
                    </div>
                </div>
                
                <div class="priceChartContent">
                    <div class="priceChart">
                        <div class="priceChartBlock">
                           
                            <div class="priceChartBlockTop" style="height: <?php echo calculatingPercentages($thirdMonth, $totalSum);?>% "> 
                                <div class="priceChartBlockNone">
                                    <p><?php echo number_format($firstMonth); ?> Руб.</p>
                                </div>
                            </div>

                            <div class="priceChartBlockMonth"><p>фев.</p></div>
                        </div>

                        <div class="priceChartBlock">
                            <div class="priceChartBlockTop" style="height: <?php echo calculatingPercentages($secondMonth, $totalSum); ?>%">
                                <div class="priceChartBlockNone">
                                    <p><?php echo number_format($secondMonth); ?> Руб.</p>
                                </div>
                            </div>

                            <div class="priceChartBlockMonth"><p>март.</p></div>
                        </div>

                        <div class="priceChartBlock">
                            <div class="priceChartBlockTop" style="height: <?php echo calculatingPercentages($firstMonth, $totalSum); ?>%">
                                <div class="priceChartBlockNone">
                                    <p><?php echo number_format($thirdMonth); ?> Руб.</p>
                                </div>
                            </div>

                            <div class="priceChartBlockMonth"><p>апр.</p></div>
                        </div>
      
                    </div>
                </div>
           </div>
        </div>
    </div>
</section>