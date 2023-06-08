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
    case 'GenerateCalendar':
        generateCalendar($res);
        break;
    default:
        $res->message = "Non se recoñece a declaración $state.";
        break;
}

function generateCalendar($res) {
    $tld = new Trilladeira();
    $seasons = explode(",", $_REQUEST['seasons']);
    $fileUrl = $GLOBALS['fileUrl'];
    $lockedDishes = json_decode($_REQUEST['lockedDishes']);

    $allDishes = [];
    foreach($seasons as $season) {
        $file = json_decode(file_get_contents($fileUrl->$season));
        $allDishes = array_merge($allDishes, $file);
    }
    for ($i = 0; $i < 10; $i++) {
        shuffle($allDishes);
    }

    switch (count($lockedDishes)) {
        case 0:
            break;
        default:
            foreach($lockedDishes as $key => $lockedDish) {
                foreach($allDishes as $dishKey => $dish) {
                    if ($lockedDish->id === $dish->id) {
                        array_splice($allDishes, $dishKey, 1);
                    }
                }
            }
            
            foreach($lockedDishes as $key => $lockedDish) {
                $lockedDish->locked = true;
                array_splice($allDishes, $lockedDish->pos, 1, array($lockedDish));
            }
            break;
    }

    array_splice($allDishes, 9);
    $weeklyTableFile = '../../data/weeklyTable.json';
    $tld->saveJSONFile($allDishes, $weeklyTableFile);
    $svgUrl = '../../client/static/svg';

    require('../../templates/weeklyMeals/weeklyTable.php');
}
?>
