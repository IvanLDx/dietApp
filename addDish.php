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
    <link rel="stylesheet" href="./client/cssV<?=$clientVersion?>/addDish.css">
    <link rel="stylesheet" href="./client/cssV<?=$clientVersion?>/components/tags.css">
    <link rel="stylesheet" href="./client/cssV<?=$clientVersion?>/components/modifyModal.css">
    <link rel="stylesheet" href="./client/cssV<?=$clientVersion?>/components/removePopup.css">
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

    <script type="module" src="./client/jsV<?=$clientVersion?>/main.js"></script>
    <script type="module" src="./client/jsV<?=$clientVersion?>/addDish.js"></script>
</body>
</html>
