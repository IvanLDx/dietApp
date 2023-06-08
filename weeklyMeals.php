<?php
require ('./server/models/Trilladeira.php');
$tld = new Trilladeira();
$dishList = $tld->getDishListSeasonFiles('./data');

$currentPageName = $tld->getPageName(__FILE__);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
    <link rel="stylesheet" href="./client/css/weeklyMeals.css">
    <link rel="stylesheet" href="./client/css/components/modifyModal.css">
    <link rel="stylesheet" href="./client/css/components/removePopup.css">
</head>
<body>
    <div class="js-page page" data-page-name="<?=$currentPageName?>">
        <div class="form-wrapper">
            <form action="Meals-GenerateCalendar" class="js-generate-calendar">
                <?php
                $section = "weeklyMeals";
                require('./templates/addDish/seasonInputs.php');        
                ?>
        
                <input type="hidden" name="locked-dishes" class="js-locked-dishes">
                <input type="submit" value="Dálle!" class="js-dalle">
            </form>

            <button class="reset js-reset">Reinicia-lo calendario</button>
        </div>

        <div class="generated-table">
            <ul class="js-table-list dish-list">
                <?php
                    $allDishes = json_decode(file_get_contents('./data/weeklyTable.json'));
                    $svgUrl = './client/static/svg';
                    require('./templates/weeklyMeals/weeklyTable.php');
                ?>
            </ul>
        </div>

        <?php require('./templates/menu.php') ?>

        <?php require('./templates/components/removePopup.php'); ?>
    </div>

    <script type="module" src="./client/js/main.js"></script>
    <script type="module" src="./client/js/weeklyMeals.js"></script>
</body>
</html>
