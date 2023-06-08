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

    public function getSeasonDishData($dishList) {
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

    public function getDishListSeasonFiles($url) {
        $dishList = (object)[
            "summer" => json_decode(file_get_contents("$url/summerDishList.json")),
            "winter" => json_decode(file_get_contents("$url/winterDishList.json")),
            "halftime" => json_decode(file_get_contents("$url/halftimeDishList.json"))
        ];

        return $dishList;
    }

    function getPageName($rawFileName) {
        return str_replace('.php', '', basename($rawFileName));
    }
}
?>