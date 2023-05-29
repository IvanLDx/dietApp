<?php

$state = $_REQUEST['state'];
$res = new stdClass();
$dishListFile = '../../data/dishList.json';
$dishList = json_decode(file_get_contents($dishListFile));

switch ($state) {
    case 'Add':
        addDish($res);
        break;
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
        $dishList[] = $newContent;
        if (isset($dishList) && count($dishList) > 0) {
            file_put_contents($GLOBALS['dishListFile'], json_encode($dishList, JSON_PRETTY_PRINT));
        }
        $res->success = true;
        $res->message = 'O prato foi engadido á lista';
    }
}

echo json_encode($res);
?>
