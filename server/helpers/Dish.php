<?php

$state = $_REQUEST['state'];
$res = new stdClass();
$dishListFile = '../../data/dishList.json';
$dishList = json_decode(file_get_contents($dishListFile));

switch ($state) {
    case 'Add':
        addDish($res);
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
    $newContent = (object)[
        "name" => $dishName
    ];
    $dishList = $GLOBALS['dishList'];

    foreach ($dishList as $dish) {
        if ($dish->name === $dishName) {
            $exists = true;
        }
    }

    if (isset($exists)) {
        $res->error = true;
        $res->message = 'Este prato xa existe!';
    } else {
        $existsID = true;
        $id = createID();
        while ($existsID) {
            foreach($dishList as $dish) {
                if ($dish->id === $id) {
                    $id = createID();
                } else {
                    $existsID = false;
                }
            }
        }
        $newContent->id = $id;
        $dishList[] = $newContent;
        if (isset($dishList) && count($dishList) > 0) {
            file_put_contents($GLOBALS['dishListFile'], json_encode($dishList, JSON_PRETTY_PRINT));
        }
        $res->success = true;
        $res->message = 'O prato foi engadido á lista';
    }
}

function refreshList() {
    $dishList = json_decode(file_get_contents('../../data/dishList.json'));
    require('../../templates/addDish/dishList.php');
}

function createID() {
    $idFormat = "############";

    while (preg_match("/#/", $idFormat)) {
        $idFormat = preg_replace("/#/", rand(0, 9), $idFormat, 1);
    }

    return $idFormat;
}

echo json_encode($res);
?>
