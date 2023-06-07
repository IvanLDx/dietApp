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
            $res->lockedDishes = $lockedDishes;

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
            
            $res->allDishes = $allDishes;

            
            break;
    }

    require('../../templates/weeklyMeals/weeklyTable.php');
}
?>