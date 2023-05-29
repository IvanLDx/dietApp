<?php
class DataModel {
    public function getJSON($name) {
        return json_decode(file_get_contents("./data/$name.json"));
    }
}
?>
