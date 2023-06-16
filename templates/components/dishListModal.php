<div class="dish-list dish-list-modal js-dish-list-modal hidden">
    <button class="close-dush-list-modal js-close-dish-list-modal">Cancela a modificación</button>
    <?php
    $dishList = $tld->getDishListSeasonFiles("$root/data");
    $tags = json_decode(file_get_contents($root . "/data/tags.json"));
    $formattedTagListUrl = "$root/templates/tags/formattedList.php";
    include "$root/templates/addDish/dishList.php";
    ?>
</div>