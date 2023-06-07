<?php
require ('./server/models/Trilladeira.php');
$tld = new Trilladeira();
$dishList = $tld->getDishListSeasonFiles('./data');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
    <link rel="stylesheet" href="./client/css/weeklyMeals.css">
</head>
<body>
    <div class="js-page page">
        <div class="form-wrapper">
            <form action="Meals-GenerateCalendar" class="js-generate-calendar">
                <?php
                $section = "weeklyMeals";
                require('./templates/addDish/seasonInputs.php');        
                ?>
        
                <input type="hidden" name="locked-dishes" class="js-locked-dishes">
                <input type="submit" value="Dálle!" class="js-dalle">
            </form>
        </div>

        <div class="generated-table">
            <ul class="js-table-list dish-list"></ul>
        </div>

        <?php require('./templates/menu.php') ?>
    </div>

    <script type="module" src="./client/js/main.js"></script>
    <script type="module" src="./client/js/weeklyMeals.js"></script>
</body>
</html>
