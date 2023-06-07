<?php
$maxMealsPerWeek = 9;
$days = [
    'Luns',
    'Martes',
    'Mércores',
    'Xoves',
    'Venres'
];
for($i = 0; $i < $maxMealsPerWeek; $i++) {
    $dish = $allDishes[$i];
    $currentDay = $i / 2;
    $isLockedDish = isset($dish->locked);

    if (floor($currentDay) == ($currentDay)) { ?>
        <p><?=$days[$currentDay]?></p>
    <?php } ?>
    <li class="js-dish-element-list dish-element-list <?=$isLockedDish ? 'locked' : ''?>"
        data-id="<?=$dish->id?>"
        data-name="<?=$dish->name?>"
        data-tags="<?=$dish->tags?>"
        data-position="<?=$i?>">
        <span><?=$dish->name?></span>

        <div class="controls">
            <span class="js-locker button">
                <span class="open-ico"><?php require('../../client/static/svg/locker-open.svg') ?></span>
                <span class="locked-ico"><?php require('../../client/static/svg/locker-closed.svg') ?></span>
            </span>
            <span class="js-refresh button"><?php require('../../client/static/svg/refresh.svg') ?></span>
            <span class="js-swap button"><?php require('../../client/static/svg/swap.svg') ?></span>
            <span class="js-copy button"><?php require('../../client/static/svg/copy.svg') ?></span>
            <span class="js-magnifier button"><?php require('../../client/static/svg/magnifier.svg') ?></span>
        </div>
    </li>
<?php }
?>