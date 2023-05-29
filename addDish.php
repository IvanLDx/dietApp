<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
    <link rel="stylesheet" href="./client/css/addDish.css">
</head>
<body>
    <div class="js-page page">
        <div class="content">
            <?php require('./templates/addDish/inputs.php'); ?>

            <div class="dish-list js-dish-list">

            </div>
        </div>

        <?php require('./templates/menu.php'); ?>
    </div>

    <script type="module" src="./client/js/main.js"></script>
    <script type="module" src="./client/js/addDish.js"></script>
</body>
</html>