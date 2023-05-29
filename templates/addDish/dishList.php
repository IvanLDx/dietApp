<ul>
    <?php
    foreach ($dishList as $dish) { ?>
        <li class="js-dish-element-list" data-id="<?=$dish->id?>" data-name="<?=$dish->name?>">
            <span><?=$dish->name?></span>
            <span class="ico remove">
                <?php require($ico->remove); ?>
            </span>
            <span class="ico modify js-modify-dish">
                <?php require($ico->modify); ?>
            </span>
        </li>
    <?php } ?>
</ul>