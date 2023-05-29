<?php

$state = $_REQUEST['state'];
$res = new stdClass();
$rootJsonFiles = '../../data';
$dishListFile = "$rootJsonFiles/dishList.json";
$fileUrl = (object)[
    "summer" => "$rootJsonFiles/summerDishList.json",
    "winter" => "$rootJsonFiles/winterDishList.json",
    "halftime" => "$rootJsonFiles/halftimeDishList.json"
];
$dishList = json_decode(file_get_contents($dishListFile));

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
    $dishName = $_REQUEST['dish-name'];
    $season = $_REQUEST['season'];
    $seasonFile = $GLOBALS['fileUrl']->$season;
    $newContent = (object)[
        "name" => $dishName
    ];
    $dishList = json_decode(file_get_contents($seasonFile));

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
        saveJSONFile($dishList, $seasonFile);

        $res->success = true;
        $res->message = 'O prato foi engadido á lista';
    }
}

function modifyDish($res) {
    $dishName = $_REQUEST['dish-name'];
    $dishID = $_REQUEST['dish-id'];
    $dishList = $GLOBALS['dishList'];

    foreach ($dishList as $dish) {
        if ($dish->id === $dishID) {
            $dish->name = $dishName;
        }
    }

    saveJSONFile($dishList);
    $res->success = true;
    $res->message = 'O prato foi modificado!';
}

function removeDish($res) {
    $dishID = $_REQUEST['dish-id'];
    $res->id = $dishID;
    $dishList = $GLOBALS['dishList'];

    foreach ($dishList as $key => $dish) {
        if ($dish->id === $dishID) {
            array_splice($dishList, $key, 1);
        }
    }

    saveJSONFile($dishList);

    $res->success = true;
}

function refreshList() {
    $dishList = (object)[
        "summer" => json_decode(file_get_contents('../../data/summerDishList.json')),
        "winter" => json_decode(file_get_contents('../../data/winterDishList.json')),
        "halftime" => json_decode(file_get_contents('../../data/halftimeDishList.json'))
    ];

    $ico = (object)[
        "modify" => "../../client/static/svg/modify.svg",
        "remove" => "../../client/static/svg/remove.svg"
    ];
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
