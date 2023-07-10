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
    case 'CopyDish':
        copyDish($res);
        break;
    case 'ModifySearchedDish':
        modifySearchedDish($res);
        break;
    case 'LockDish':
        lockDish($res);
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
    $selectedToSwap = json_decode($_REQUEST['firstSelectedDish']);
    $swapWithSelected = json_decode($_REQUEST['secondSelectedDish']);
    
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

function copyDish($res) {
    $tld = new Trilladeira();
    $selectedToCopy = json_decode($_REQUEST['firstSelectedDish']);
    $copySelected = json_decode($_REQUEST['secondSelectedDish']);
    
    $weeklyTableUrl = '../../data/weeklyTable.json';
    $weeklyTable = json_decode(file_get_contents($weeklyTableUrl));
    $selectedToCopyBack =  $weeklyTable[$selectedToCopy->pos];

    array_splice($weeklyTable, $copySelected->pos, 1, array($selectedToCopyBack));

    $tld->saveJSONFile($weeklyTable, $weeklyTableUrl);

    $svgUrl = '../../client/static/svg';
    $allDishes = $weeklyTable;
    
    require('../../templates/weeklyMeals/weeklyTable.php');
}

function modifySearchedDish($res) {
    $tld = new Trilladeira();
    $selectedToModify = json_decode($_REQUEST['firstSelectedDish']);
    $copySelected = json_decode($_REQUEST['secondSelectedDish']);
    
    $weeklyTableUrl = '../../data/weeklyTable.json';
    $weeklyTable = json_decode(file_get_contents($weeklyTableUrl));
    $selectedToModifyBack =  $weeklyTable[$selectedToModify->pos];
    $url = '../../data';
    $dishSeasonFiles = $tld->getDishListSeasonFiles($url);
    $allSeasonDishes = [];
    foreach($dishSeasonFiles as $seasonFile) {
        $allSeasonDishes = array_merge($allSeasonDishes, $seasonFile);
    }
    
    foreach($allSeasonDishes as $seasonDish) {
        if ($copySelected->id === $seasonDish->id) {
            array_splice($weeklyTable, $selectedToModify->pos, 1, array($seasonDish));
            break;
        }
    }

    $tld->saveJSONFile($weeklyTable, $weeklyTableUrl);

    $svgUrl = '../../client/static/svg';
    $allDishes = $weeklyTable;
    $res->weeklyTable = $weeklyTable;
    $res->selectedToModify = $selectedToModify;
    $res->copySelected = $copySelected;

    require('../../templates/weeklyMeals/weeklyTable.php');
}

function lockDish($res) {
    $tld = new Trilladeira();
    $lockedDishes = json_decode($_REQUEST['lockedDishes']);
    $weeklyTableUrl = '../../data/weeklyTable.json';
    $allDishes = json_decode(file_get_contents($weeklyTableUrl));

    switch (count($lockedDishes)) {
        case 0:
            break;
        default:
            foreach($allDishes as $dishKey => $dish) {
                $isCurrentDishLocked = false;
                foreach($lockedDishes as $key => $lockedDish) {
                    if ($lockedDish->id === $dish->id) {
                        $isCurrentDishLocked = true;
                    }
                }
                if ($isCurrentDishLocked) {
                    $dish->locked = true;
                } else {
                    if (isset($dish->locked)) {
                        unset($dish->locked);
                    }
                }
            }
            break;
    }
    $tld->saveJSONFile($allDishes, $weeklyTableUrl);
    $svgUrl = '../../client/static/svg';

    require('../../templates/weeklyMeals/weeklyTable.php');
}
?>
