<?php

$state = $_REQUEST['state'];
$res = new stdClass();
$rootJsonFiles = '../../data';
$fileUrl = "$rootJsonFiles/tags.json";

$res->asdasd = $state;

switch ($state) {
    case 'Add':
        addTag($res);
        break;
    case 'Remove':
        removeTag($res);
        break;
    case 'RefreshList':
        refreshTags();
        return;
    default:
        $res->message = "Non se recoñece a declaración $state.";
        break;
}

function addTag($res) {
    $tagName = $_REQUEST['tag-name'];
    $tagColor = $_REQUEST['tag-color'];
    $res->asd = $tagColor;
    $fileUrl = $GLOBALS['fileUrl'];
    $newContent = (object)[
        "name" => $tagName,
        "color" => $tagColor
    ];
    $tagList = json_decode(file_get_contents($fileUrl));

    foreach ($tagList as $tag) {
        if ($tag->name === $tagName) {
            $exists = true;
        }
    }

    if (isset($exists)) {
        $res->error = true;
        $res->message = 'Esta etiqueta xa existe!';
    } else {
        $existsID = false;
        $id = createID();
        do {
            foreach($tagList as $tag) {
                if ($tag->id === $id) {
                    $id = createID();
                    $existsID = true;
                }
            }

        } while ($existsID);

        $newContent->id = $id;
        $tagList[] = $newContent;
        saveJSONFile($tagList, $fileUrl);

        $res->success = true;
        $res->message = 'A etiqueta foi engadida á lista';
    }
}

function removeTag($res) {
    $dishID = $_REQUEST['dish-id'];
    $season = $_REQUEST['season'];
    $seasonFile = $GLOBALS['fileUrl']->$season;
    $dishList = json_decode(file_get_contents($seasonFile));

    foreach ($dishList as $key => $dish) {
        if ($dish->id === $dishID) {
            array_splice($dishList, $key, 1);
        }
    }

    saveJSONFile($dishList, $seasonFile);

    $res->success = true;
}

function refreshTags() {
    // $dishList = (object)[
    //     "summer" => json_decode(file_get_contents('../../data/summerDishList.json')),
    //     "winter" => json_decode(file_get_contents('../../data/winterDishList.json')),
    //     "halftime" => json_decode(file_get_contents('../../data/halftimeDishList.json'))
    // ];

    // $ico = (object)[
    //     "modify" => "../../client/static/svg/modify.svg",
    //     "remove" => "../../client/static/svg/remove.svg"
    // ];
    // require('../../templates/addDish/dishList.php');
}

function createID() {
    $idFormat = "############";

    while (preg_match("/#/", $idFormat)) {
        $idFormat = preg_replace("/#/", rand(0, 9), $idFormat, 1);
    }

    return $idFormat;
}

function saveJSONFile($dishList, $seasonFile) {
    if (isset($dishList) && count($dishList) > 0) {
        file_put_contents($seasonFile, json_encode($dishList, JSON_PRETTY_PRINT));
    }
}

echo json_encode($res);
?>
