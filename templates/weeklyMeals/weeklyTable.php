<?php
$maxMealsPerWeek = 9;
$days = [
    'Luns',
    'Martes',
    'Mércores',
    'Xoves',
    'Venres'
];

function getCurrentDate($date) {
    return [$date['wday'], $date['hours']];
}

function getDinnerGone($date) {
    return getCurrentDate($date)[1] > 16;
}

function getLunchGone($date, $i) {
    return getCurrentDate($date)[0] > $i - 1;
}

function getMealGone($date, $i) {
    return (
        getLunchGone($date, $i)
        || (
            (getCurrentDate($date)[0] > $i - 2)
            && getDinnerGone($date)
            && !($i % 2)
        )
    );
}

for($i = 0; $i < $maxMealsPerWeek; $i++) {
    $dish = $allDishes[$i];
    $currentDay = $i / 2;
    $isLockedDish = isset($dish->locked);

    if (isset($date)) {
        $mealGone = getMealGone($date, $i) ? 'meal-done' : '';
    } else {
        $mealGone = '';
    }

    if (floor($currentDay) == ($currentDay)) { ?>
        <p><?=$days[$currentDay]?></p>
    <?php } ?>
    <li class="js-dish-element-list dish-element-list <?=$isLockedDish ? 'locked' : ''?> <?=$mealGone?>"
        data-id="<?=$dish->id?>"
        data-name="<?=$dish->name?>"
        data-tags="<?=$dish->tags?>"
        data-position="<?=$i?>">
        <span class="js-dish-element-name"><?=$dish->name?></span>

        <?php if (!isset($isHomePage)) { ?>
            <div class="controls">
                <span class="js-locker button button__locker">
                    <span class="open-ico"><?= file_get_contents($svgUrl . "/locker-open.svg") ?></span>
                    <span class="locked-ico"><?= file_get_contents($svgUrl . "/locker-closed.svg") ?></span>
                </span>
                <span class="js-refresh button button__refresh"><?= file_get_contents($svgUrl . "/refresh.svg") ?></span>
                <span class="js-swap button button__swap"><?= file_get_contents($svgUrl . "/swap.svg") ?></span>
                <span class="js-copy button button__copy"><?= file_get_contents($svgUrl . "/copy.svg") ?></span>
                <span class="js-magnifier button button__magnifier"><?= file_get_contents($svgUrl . "/magnifier.svg") ?></span>
            </div>
        <?php } ?>
    </li>
<?php }
?>
