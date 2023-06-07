<div class="season-inputs js-season-inputs">
    <?php
    $seasons = $tld->getSeasonDishData($dishList);

    $inputType = $section === 'weeklyMeals' ? 'checkbox' : 'radio';

    foreach($seasons as $season) {
        $isWeeklyMeals = $section === 'weeklyMeals';
        $isHalftimeSeason = $season->id === 'halftime';
        $needsDefaultChecked = $isWeeklyMeals && $isHalftimeSeason;
        ?>
        <div class="<?=$season->id?>-container">
            <input type="<?=$inputType?>"
                name="season<?=$isWeeklyMeals ? "-$season->id" : ''?>"
                value="<?=$season->id?>"
                id="<?=$section?>-<?=$season->id?>"
                class="js-season-radio"
                <?=$needsDefaultChecked ? 'checked' : ''?>>
            <label for="<?=$section?>-<?=$season->id?>"><?=ucfirst($season->title)?></label>
        </div>
    <?php } ?>
</div>