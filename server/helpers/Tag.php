<?php

$state = $_REQUEST['state'];
$res = new stdClass();
$rootJsonFiles = '../../data';
$fileUrl = "$rootJsonFiles/tags.json";

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
    $tagID = $_REQUEST['tag-id'];

    $fileUrl = $GLOBALS['fileUrl'];
    $tags = json_decode(file_get_contents($fileUrl));
    
    foreach ($tags as $key => $tag) {
        $res->asd[]= $tag->id;
        $res->asd[]= $tagID;
        if ($tag->id === $tagID) {
            array_splice($tags, $key, 1);
        }
    }

    saveJSONFile($tags, $fileUrl);

    $res->success = true;
}

function refreshTags() {
    $fileUrl = $GLOBALS['fileUrl'];
    $tags = json_decode(file_get_contents($fileUrl));
    $iconUrl = '../../client/static/svg/close.svg';

    require('../../templates/tags/list.php');
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
