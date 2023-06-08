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
    case 'ModifyDish':
        modifyDish($res);
        break;
    case 'SwapDishes':
        swapDishes($res);
        break;
    default:
        $res->message = "Non se recoñece a declaración $state.";
        echo json_encode($res);
        break;
}

function generateCalendar($res) {
    $tld = new Trilladeira();
    $lockedDishes = json_decode($_REQUEST['lockedDishes']);
    $allDishes = $tld->mergeSeasonDishes($_REQUEST['seasons']);

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

function modifyDish($res) {
    $tld = new Trilladeira();
    $dishID = $_REQUEST['dishID'];
    $dishPos = $_REQUEST['dishPos'];
    $weeklyTableUrl = '../../data/weeklyTable.json';
    $weeklyTable = json_decode(file_get_contents($weeklyTableUrl));
    $allDishes = $tld->mergeSeasonDishes($_REQUEST['seasons']);

    $i = 0;
    $dishExistsOnTable = true;
    while ($i < count($allDishes) && $dishExistsOnTable) {
        $dishExistsOnTable = false;
        $dishToAdd = $allDishes[$i];

        foreach($weeklyTable as $keyTableDish => $tableDish) {
            if ($tableDish->id === $dishToAdd->id) {
                $dishExistsOnTable = true;
                break;
            }
        }
        if ($dishExistsOnTable) {
            $i++;
        }
    }

    $res->newDish = $allDishes[$i];
    array_splice($weeklyTable, $dishPos, 1, array($res->newDish));
    $res->success = true;

    $tld->saveJSONFile($weeklyTable, $weeklyTableUrl);

    echo json_encode($res);
}

function swapDishes($res) {
    $tld = new Trilladeira();
    $selectedToSwap = json_decode($_REQUEST['selectedToSwap']);
    $swapWithSelected = json_decode($_REQUEST['swapWithSelected']);
    
    $weeklyTableUrl = '../../data/weeklyTable.json';
    $weeklyTable = json_decode(file_get_contents($weeklyTableUrl));
    $selectedToSwapBack = $weeklyTable[$selectedToSwap->pos];
    $swapWithSelectedBack =  $weeklyTable[$swapWithSelected->pos];

    array_splice($weeklyTable, $selectedToSwap->pos, 1, array($swapWithSelectedBack));
    array_splice($weeklyTable, $swapWithSelected->pos, 1, array($selectedToSwapBack));

    $tld->saveJSONFile($weeklyTable, $weeklyTableUrl);

    $svgUrl = '../../client/static/svg';
    $allDishes = $weeklyTable;
    
    require('../../templates/weeklyMeals/weeklyTable.php');
}
?>
