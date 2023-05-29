<?php
$seasons = [
    (object) [
        "file" => $dishList->summer,
        "title" => "verán"
    ],
    (object) [
        "file" => $dishList->winter,
        "title" => "inverno"
    ],
    (object) [
        "file" => $dishList->halftime,
        "title" => "entretempo"
    ]
];

foreach ($seasons as $season) { ?>
    <p class="season-title">Pratos de <?=$season->title?></p>
    <ul>
        <?php
        foreach ($season->file as $dish) { ?>
            <li class="js-dish-element-list" data-id="<?=$dish->id?>" data-name="<?=$dish->name?>">
                <span><?=$dish->name?></span>
                <span class="ico remove js-remove-dish">
                    <?php require($ico->remove); ?>
                </span>
                <span class="ico modify js-modify-dish">
                    <?php require($ico->modify); ?>
                </span>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
