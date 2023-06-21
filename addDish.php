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
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/addDish.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/tags.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/modifyModal.css">
    <link rel="stylesheet" href="./clientV<?=$clientVersion?>/css/components/removePopup.css">
</head>
<body>
    <div class="js-page page" data-page-name="<?=$currentPageName?>">
        <div class="content">
            <?php include "$root/templates/addDish/inputs.php" ?>

            <div class="dish-list js-dish-list">
                <?php
                $svgFolder = "$root/client/static/svg";
                $ico = (object)[
                    "modify" => "$svgFolder/modify.svg",
                    "remove" => "$svgFolder/remove.svg"
                ];
                $formattedTagListUrl = "$root/templates/tags/formattedList.php";
                include "$root/templates/addDish/dishList.php";
                ?>
            </div>
        </div>

        <?php include "$root/templates/menu.php" ?>

        <?php include "$root/templates/components/modifyModal.php" ?>
        <?php include "$root/templates/components/removePopup.php" ?>
    </div>

    <script type="module" src="./clientV<?=$clientVersion?>/js/main.js"></script>
    <script type="module" src="./clientV<?=$clientVersion?>/js/addDish.js"></script>
</body>
</html>
