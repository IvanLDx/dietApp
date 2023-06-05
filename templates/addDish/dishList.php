<?php
$seasons = [
    (object) [
        "file" => $dishList->summer,
        "id" => "summer",
        "title" => "verán"
    ],
    (object) [
        "file" => $dishList->winter,
        "id" => "winter",
        "title" => "inverno"
    ],
    (object) [
        "file" => $dishList->halftime,
        "id" => "halftime",
        "title" => "entretempo"
    ]
];

foreach ($seasons as $season) { ?>
    <p class="season-title">Pratos de <?=$season->title?></p>
    <ul>
        <?php
        foreach ($season->file as $dish) { ?>
            <li class="js-dish-element-list dish-element-list" data-id="<?=$dish->id?>" data-name="<?=$dish->name?>" data-season="<?=$season->id?>" data-tags="<?=$dish->tags?>">
                <span><?=$dish->name?></span>
                
                <div class="dish-tags">
                    <?php
                        if (isset($dish->tags)) {
                            $tagIDs = explode(", ", $dish->tags);
                            $tagsRaw = $tags;
                            $tags = [];
                            foreach ($tagIDs as $tagID) {
                                foreach ($tagsRaw as $tag) {
                                    if ($tagID === $tag->id) {
                                        $tags[] = $tag;
                                    }
                                }
                            }
                            require('./templates/tags/formattedList.php');
                        }
                    ?>
                </div>

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
