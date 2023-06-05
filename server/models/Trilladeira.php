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
}
?>