<?php
require ('../../server/models/Trilladeira.php');
$state = $_REQUEST['state'];
$res = new stdClass();
$rootJsonFiles = '../../data';
$fileUrl = (object)[
    "summer" => "$rootJsonFiles/summerDishList.json",
    "winter" => "$rootJsonFiles/winterDishList.json",
    "halftime" => "$rootJsonFiles/halftimeDishList.json"
];

switch ($state) {
    case 'Add':
        addDish($res);
        break;
    case 'Modify':
        modifyDish($res);
        break;
    case 'Remove':
        removeDish($res);
        break;
    case 'RefreshList':
        refreshList();
        return;
    default:
        $res->message = "Non se recoñece a declaración $state.";
        break;
}

function addDish($res) {
    $tld = new Trilladeira();
    $dishName = $_REQUEST['dish-name'];
    $season = $_REQUEST['season'];
    $tags = $_REQUEST['tags'];
    $seasonFile = $GLOBALS['fileUrl']->$season;
    $newContent = (object)[
        "name" => $dishName,
        "tags" => $tags
    ];
    $dishList = json_decode(file_get_contents($seasonFile));

    $tld->createBackups();

    foreach ($dishList as $dish) {
        if ($dish->name === $dishName) {
            $exists = true;
        }
    }

    if (isset($exists)) {
        $res->error = true;
        $res->message = 'Este prato xa existe!';
    } else {
        $existsID = false;
        $id = createID();
        do {
            foreach($dishList as $dish) {
                if ($dish->id === $id) {
                    $id = createID();
                    $existsID = true;
                }
            }

        } while ($existsID);

        $newContent->id = $id;
        $dishList[] = $newContent;
        $dishList = $tld->sortByName($dishList);

        saveJSONFile($dishList, $seasonFile);

        $res->success = true;
        $res->message = 'O prato foi engadido á lista';
    }
}

function modifyDish($res) {
    $tld = new Trilladeira();
    $dishName = $_REQUEST['dish-name'];
    $dishID = $_REQUEST['dish-id'];
    $season = $_REQUEST['season'];
    $tags = $_REQUEST['tags'];
    $seasonFile = $GLOBALS['fileUrl']->$season;
    $dishList = json_decode(file_get_contents($seasonFile));
    $isInThisSeason = false;

    $tld->createBackups();

    foreach ($dishList as $dish) {
        if ($dish->id === $dishID) {
            $dish->name = $dishName;
            $dish->tags = $tags;
            $isInThisSeason = true;
        }
    }

    if ($isInThisSeason) {
        $dishList = $tld->sortByName($dishList);
        saveJSONFile($dishList, $seasonFile);
    } else {
        removeDishGlobalSeasons($res);
        addDish($res);
    }

    $res->success = true;
    $res->message = 'O prato foi modificado!';
}

function removeDishGlobalSeasons($res) {
    $tld = new Trilladeira();
    $tld->createBackups();

    $dishID = $_REQUEST['dish-id'];
    $dishFoundInFile = false;
    foreach ($GLOBALS['fileUrl'] as $i => $fileUrl) {
        $dishList = json_decode(file_get_contents($fileUrl));

        if (!$dishFoundInFile) {
            foreach ($dishList as $key => $dish) {
                if ($dish->id === $dishID && !$dishFoundInFile) {
                    array_splice($dishList, $key, 1);
                    $dishFoundInFile = true;
                    $currentSession = $i;
                    $currentList = $dishList;
                }
            }
        }
    }

    saveJSONFile($currentList, $GLOBALS['fileUrl']->$currentSession);
}

function removeDish($res) {
    $tld = new Trilladeira();
    $dishID = $_REQUEST['dish-id'];
    $season = $_REQUEST['season'];
    $seasonFile = $GLOBALS['fileUrl']->$season;
    $dishList = json_decode(file_get_contents($seasonFile));

    $tld->createBackups();

    foreach ($dishList as $key => $dish) {
        if ($dish->id === $dishID) {
            array_splice($dishList, $key, 1);
        }
    }

    saveJSONFile($dishList, $seasonFile);

    $res->success = true;
}

function refreshList() {
    $tld = new Trilladeira();
    $dishList = $tld->getDishListSeasonFiles('../../data');
    $tags = json_decode(file_get_contents('../../data/tags.json'));
    $formattedTagListUrl = '../../templates/tags/formattedList.php';
    $iconUrl = '../../client/static/svg/close.svg';
    $ico = (object)[
        "modify" => "../../client/static/svg/modify.svg",
        "remove" => "../../client/static/svg/remove.svg"
    ];
    $currentPageName = 'addDish';
    require('../../templates/addDish/dishList.php');
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
