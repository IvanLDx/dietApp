<!--
    https://www.canva.com/design/DAFfCbbyZ14/_rwABpLzTq-1c06VmL2BZA/edit?utm_content=DAFfCbbyZ14&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton
-->

<?php
require "scripts/models/DataModel.php";
$DataModel = new DataModel();
$account = json_decode(file_get_contents("./data/account.json"));
$pods = json_decode(file_get_contents("./data/podcasts.json"));
$watchingPodcast = $account->watchingPodcast[0];
$efemeridas = $pods[0];

function template($name) {
    return include ("./templates/$name.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("./templates/head.php") ?>
</head>
<body>
    <?php include ("./templates/decoration.php") ?>

    <div class="page background-black">
        <?php
            include ("./templates/vinylBox.php");
            include ("./templates/controlsBox.php");
            include ("./templates/listOfEpisodes.php");
        ?>
    </div>

    <script type="module" src="client/js/main.js"></script>
</body>
</html>
