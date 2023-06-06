<div class="season-inputs js-season-inputs">
    <?php
    $seasons = $tld->getSeasonDishData($dishList);

    foreach($seasons as $season) { ?>
        <div class="<?=$season->id?>-container">
            <input type="radio" name="season" value="<?=$season->id?>" id="<?=$section?>-<?=$season->id?>" class="js-season-radio">
            <label for="<?=$section?>-<?=$season->id?>"><?=ucfirst($season->title)?></label>
        </div>
    <?php } ?>
</div>