<?php
$root = dirname(__FILE__);
include "$root/server/models/Trilladeira.php";
$tld = new Trilladeira();
$dishList = $tld->getDishListSeasonFiles("$root/data");
$clientVersion = $tld->getJSONFile("clientVersion");
$currentPageName = $tld->getPageName(__FILE__);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "$root/templates/head.php" ?>
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/tags.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/weeklyMeals.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/modifyModal.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/removePopup.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/dishListModal.css">
</head>
<body>
    <div class="js-page page" data-page-name="<?=$currentPageName?>">
        <div class="form-wrapper">
            <form action="Meals-GenerateCalendar"
                data-action-modify-dish="Meals-ModifyDish"
                data-action-swap-dishes="Meals-SwapDishes"
                data-action-copy-dish="Meals-CopyDish"
                data-action-modify-searched-dish="Meals-ModifySearchedDish"
                class="js-generate-calendar">
                <?php
                $section = "weeklyMeals";
                include "$root/templates/addDish/seasonInputs.php";        
                ?>
        
                <input type="hidden" name="locked-dishes" class="js-locked-dishes">
                <input type="submit" value="Dálle!" class="js-dalle">
            </form>

            <button class="reset js-reset">Reinicia-lo calendario</button>
        </div>

        <div class="generated-table">
            <ul class="js-table-list dish-list">
                <?php
                    $allDishes = json_decode(file_get_contents($root . "/data/weeklyTable.json"));
                    $svgUrl = "$root/clientV' . $clientVersion . '/static/svg";
                    include "$root/templates/weeklyMeals/weeklyTable.php";
                ?>
            </ul>
        </div>

        <?php include "$root/templates/menu.php" ?>
        <?php include "$root/templates/components/dishListModal.php"; ?>
        <?php include "$root/templates/components/removePopup.php"; ?>
    </div>

    <script type="module" src="./clientV<?=$clientVersion?>/js/main.js"></script>
    <script type="module" src="./clientV<?=$clientVersion?>/js/weeklyMeals.js"></script>
</body>
</html>
