<?php
$state = $_REQUEST['state'];
$res = new stdClass();
$rootJsonFiles = '../../data';
$fileUrl = (object)[
    "summer" => "$rootJsonFiles/summerDishList.json",
    "winter" => "$rootJsonFiles/winterDishList.json",
    "halftime" => "$rootJsonFiles/halftimeDishList.json"
];

switch ($state) {
    case 'GenerateCalendar':
        generateCalendar($res);
        break;
    case 'Modify':
        break;
    case 'Remove':
        break;
    case 'RefreshList':
        return;
    default:
        $res->message = "Non se recoñece a declaración $state.";
        break;
}

function generateCalendar($res) {
    $seasons = explode(",", $_REQUEST['seasons']);
    $fileUrl = $GLOBALS['fileUrl'];

    $allDishes = [];
    foreach($seasons as $season) {
        $file = json_decode(file_get_contents($fileUrl->$season));
        $allDishes = array_merge($allDishes, $file);
    }
    for ($i = 0; $i < 10; $i++) {
        shuffle($allDishes);
    }
    $tags = json_decode(file_get_contents('../../data/tags.json'));
    require('../../templates/weeklyMeals/weeklyTable.php');
    $res->allDishes = $allDishes;
}

// echo json_encode($res);
?>