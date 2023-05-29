<ul>
    <?php
    foreach ($dishList as $dish) { ?>
        <li data-id="<?=$dish->id?>"><?=$dish->name?></li>
    <?php } ?>
</ul>