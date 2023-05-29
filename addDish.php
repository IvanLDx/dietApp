<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
    <link rel="stylesheet" href="./client/css/addDish.css">
    <link rel="stylesheet" href="./client/css/components/modifyModal.css">
</head>
<body>
    <div class="js-page page">
        <div class="content">
            <?php require('./templates/addDish/inputs.php'); ?>

            <div class="dish-list js-dish-list">
                <?php
                $dishList = json_decode(file_get_contents('./data/dishList.json'));
                $svgFolder = "./client/static/svg";
                $ico = (object)[
                    "modify" => "$svgFolder/modify.svg",
                    "remove" => "$svgFolder/remove.svg"
                ];
                require('./templates/addDish/dishList.php'); ?>
            </div>
        </div>

        <?php require('./templates/menu.php'); ?>

        <?php require('./templates/components/modifyModal.php'); ?>
    </div>

    <script type="module" src="./client/js/main.js"></script>
    <script type="module" src="./client/js/addDish.js"></script>
</body>
</html>
