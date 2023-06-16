<ul>
    <?php
    foreach ($tags as $tag) {
        if (!isset($tag->removed)) {
            $colorSlpit = str_split($tag->color);
            $total = 0;
            $value = (object)[
                '0' => 16,
                '1' => 15,
                '2' => 14,
                '3' => 13,
                '4' => 12,
                '5' => 11,
                '6' => 10,
                '7' => 9,
                '8' => 8,
                '9' => 7,
                'a' => 6,
                'b' => 5,
                'c' => 4,
                'd' => 3,
                'e' => 2,
                'f' => 1,
            ];
            foreach ($colorSlpit as $i => $str) {
                $total = $total + $value->$str;
            }
        ?>
        <li class="js-tag-element-list tag-element <?=$total < 50 ? 'black-color' : 'white-color'?>" data-id="<?=$tag->id?>" data-name="<?=$tag->name?>" data-color="<?=$tag->color?>" style="background-color: #<?=$tag->color?>">
            <?=$tag->name?>
            <span class="remove-tag js-remove-tag">
                <?php
                    if (isset($iconUrl)) {
                        echo file_get_contents($iconUrl);
                    }
                ?>
            </span>
        </li>
        <?php }
    } ?>
</ul>
