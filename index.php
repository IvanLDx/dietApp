<?php
$root = dirname(__FILE__);
include "$root/server/models/Trilladeira.php";
$tld = new Trilladeira();
$clientVersion = $tld->getJSONFile("clientVersion");
$date = getdate();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "$root/templates/head.php" ?>
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/home.css">
</head>
<body>
    <div class="js-page page">
        <div class="generated-table">
            <ul class="dish-list">
                <?php
                $allDishes = json_decode(file_get_contents($root . "/data/weeklyTable.json"));
                $isHomePage = true;
                include "$root/templates/weeklyMeals/weeklyTable.php";
                ?>
            </ul>
        </div>

        <?php include "$root/templates/menu.php" ?>
    </div>

    <script type="module" src="./clientV<?=$clientVersion?>/js/main.js"></script>
</body>
</html>