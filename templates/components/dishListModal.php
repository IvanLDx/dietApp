<div class="dish-list dish-list-modal js-dish-list-modal hidden">
    <button class="close-dush-list-modal js-close-dish-list-modal">Cancela a modificación</button>
    <?php
    $dishList = $tld->getDishListSeasonFiles('./data');
    $tags = json_decode(file_get_contents('./data/tags.json'));
    $formattedTagListUrl = './templates/tags/formattedList.php';
    $iconUrl = './client/static/svg/close.svg';
    require('./templates/addDish/dishList.php');
    ?>
</div>