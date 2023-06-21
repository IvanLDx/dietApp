<?php
class Trilladeira {
    public function createID() {
        $idFormat = "########";
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
        while (preg_match("/#/", $idFormat)) {
            $idFormat = preg_replace("/#/", $chars[rand(0, strlen($chars))], $idFormat, 1);
        }

        return $idFormat;
    }

    public function saveJSONFile($datatoFile, $fileUrl) {
        if (isset($datatoFile) && count($datatoFile) > 0) {
            file_put_contents($fileUrl, json_encode($datatoFile, JSON_PRETTY_PRINT));
        }
    }

    public function getJSONFile($jsonFileName) {
        return json_decode(file_get_contents("./data/$jsonFileName.json"));
    }

    public function getSeasonDishData($dishList) {
        return getSeasonDishData($dishList);
    }

    public function getDishListSeasonFiles($url) {
        return getDishListSeasonFiles($url);
    }

    public function sortByName($array) {
        $tagNames = [];
        foreach ($array as $tag) {
            $tagNames[] = strtolower($tag->name);
        }

        array_multisort($tagNames, $array);

        return $array;
    }

    function getPageName($rawFileName) {
        return str_replace('.php', '', basename($rawFileName));
    }

    function mergeSeasonDishes($seasonsRaw) {
        $fileUrl = $GLOBALS['fileUrl'];
        $seasons = explode(",", $seasonsRaw);
        $allDishes = [];
        foreach($seasons as $season) {
            $file = json_decode(file_get_contents($fileUrl->$season));
            $allDishes = array_merge($allDishes, $file);
        }
        for ($i = 0; $i < 10; $i++) {
            shuffle($allDishes);
        }
        return $allDishes;
    }

    public function createBackups() {
        $JSONFileUrl = "../../data";
        $dishList = getDishListSeasonFiles($JSONFileUrl);
        $seasonDishData = getSeasonDishData($dishList);

        foreach($seasonDishData as $season) {
            $dishName = $season->id . "DishList";
            $backupUrl = "$JSONFileUrl/backups/$dishName/".$_REQUEST['date'].".json";
            $fileExists = file_exists($backupUrl);
            
            if (!$fileExists) {
                copy("$JSONFileUrl/".$dishName.".json", $backupUrl);
            }
        }

    }
}

function getSeasonDishData($dishList) {
    $seasons = [
        (object) [
            "file" => $dishList->summer,
            "id" => "summer",
            "title" => "verán"
        ],
        (object) [
            "file" => $dishList->winter,
            "id" => "winter",
            "title" => "inverno"
        ],
        (object) [
            "file" => $dishList->halftime,
            "id" => "halftime",
            "title" => "entretempo"
        ]
    ];

    return $seasons;
}

function getDishListSeasonFiles($url) {
    $dishList = (object)[
        "summer" => json_decode(file_get_contents("$url/summerDishList.json")),
        "winter" => json_decode(file_get_contents("$url/winterDishList.json")),
        "halftime" => json_decode(file_get_contents("$url/halftimeDishList.json"))
    ];

    return $dishList;
}
?>
