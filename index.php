<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
    <link rel="stylesheet" href="./client/css/home.css">
</head>
<body>
    <div class="js-page page">
        <div class="generated-table">
            <ul class="dish-list">
                <?php
                $allDishes = json_decode(file_get_contents('./data/weeklyTable.json'));
                $isHomePage = true;
                require('./templates/weeklyMeals/weeklyTable.php');
                ?>
            </ul>
        </div>

        <?php require('./templates/menu.php') ?>
    </div>

    <script type="module" src="./client/js/main.js"></script>
</body>
</html>