<?php
$seasons = $tld->getSeasonDishData($dishList);
$tagsRaw = $tags;

foreach ($seasons as $season) { ?>
    <p class="season-title">Pratos de <?=$season->title?></p>
    <ul>
        <?php
        foreach ($season->file as $dish) { ?>
            <li class="js-dish-element-list dish-element-list"
                data-id="<?=$dish->id?>"
                data-name="<?=$dish->name?>"
                data-season="<?=$season->id?>"
                data-tags="<?=$dish->tags?>">
                <div class="grid-content">
                    <span><?=$dish->name?></span>
                    
                    <div class="dish-tags">
                        <?php
                            if (isset($dish->tags)) {
                                $tagIDs = explode(", ", $dish->tags);
                                
                                $tags = [];
                                foreach ($tagIDs as $tagID) {
                                    foreach ($tagsRaw as $tag) {
                                        if ($tagID === $tag->id) {
                                            $tags[] = $tag;
                                        }
                                    }
                                }
                                include $formattedTagListUrl;
                            }
                        ?>
                    </div>
                </div>

                <?php
                switch($currentPageName) {
                    case 'addDish': ?>
                        <div class="grid-controls">
                            <span class="ico modify js-modify-dish">
                                <?php echo file_get_contents($ico->modify) ?>
                            </span>
                            <span class="ico remove js-remove-dish">
                                <?php echo file_get_contents($ico->remove) ?>
                            </span>
                        </div>
                        <?php break;
                    case 'weeklyMeals': ?>
                        <span class="select js-select">Seleccióname!</span>
                        <?php break;
                }
                ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
