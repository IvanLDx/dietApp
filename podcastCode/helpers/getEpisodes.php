<?php
$id = $_REQUEST['id'];

$pods = json_decode(file_get_contents("../data/podcasts.json"));

for ($i = 0; $i < count($pods); $i++) {
    $pod = $pods[$i];
    if ($id === $pod->id) {
        $content = $pod->content;
    }
}

if ($content) {?>
    <ul>
    <?php foreach ($content as $ep) { ?>
        <li class="js-player-li" data-season="<?=$ep->season?>" data-episode="<?=$ep->episode?>">
            <div>S<?=$ep->season?>E<?=$ep->episode?></div>
            <div><?=$ep->date?></div>
        </li>
    <?php } ?>
    </ul>
    <?php
}
?>
