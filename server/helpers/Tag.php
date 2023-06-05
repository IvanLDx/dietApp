<?php

require('../../server/models/Trilladeira.php');
$tld = new Trilladeira();

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
    $tld = $GLOBALS['tld'];
    $tagName = $_REQUEST['tag-name'];
    $tagColor = $_REQUEST['tag-color'];
    $fileUrl = $GLOBALS['fileUrl'];
    $newContent = (object)[
        "name" => $tagName,
        "color" => $tagColor
    ];
    $tagList = json_decode(file_get_contents($fileUrl));

    foreach ($tagList as $tag) {
        if ($tag->name === $tagName) {
            if (isset($tag->removed)) {
                $removedID = $tag->id;
            } else {
                $exists = true;
            }
        }
    }

    if (isset($exists)) {
        $res->error = true;
        $res->message = 'Esta etiqueta xa existe!';
    } else {
        if (isset($removedID)) {
            foreach($tagList as $tag) {
                if ($tag->id === $removedID) {
                    unset($tag->removed);
                    $tag->color = $tagColor;
                }
            }
        } else {
            $existsID = false;
            $id = $tld->createID();
            $res->id = $id;
            do {
                foreach($tagList as $tag) {
                    if ($tag->id === $id) {
                        $id = $tld->createID();
                        $existsID = true;
                    }
                }
            } while ($existsID);
    
            $newContent->id = $id;
            $tagList[] = $newContent;
        }
        $tld->saveJSONFile($tagList, $fileUrl);

        $res->success = true;
        $res->message = 'A etiqueta foi engadida á lista';
    }
}

function removeTag($res) {
    $tagID = $_REQUEST['tag-id'];
    $tld = $GLOBALS['tld'];
    $fileUrl = $GLOBALS['fileUrl'];
    $tags = json_decode(file_get_contents($fileUrl));
    
    foreach ($tags as $key => $tag) {
        if ($tag->id === $tagID) {
            $tag->removed = true;
        }
    }

    $tld->saveJSONFile($tags, $fileUrl);

    $res->success = true;
}

function refreshTags() {
    $fileUrl = $GLOBALS['fileUrl'];
    $tags = json_decode(file_get_contents($fileUrl));
    $iconUrl = '../../client/static/svg/close.svg';

    require('../../templates/tags/list.php');
}

echo json_encode($res);
?>
