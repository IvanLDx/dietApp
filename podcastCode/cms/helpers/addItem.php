<?php
$pods = json_decode(file_get_contents("../../data/podcasts.json"));
$res = new stdClass();
$formData = new stdClass();
$formPod = $_REQUEST['pod'];
$formData->name = $_REQUEST['name'];
$formData->date = $_REQUEST['date'];
$formData->season = $_REQUEST['season'];
$formData->episode = $_REQUEST['episode'];

$res->pods = $pods;

foreach ($pods as $key) {
    if ($key->id === $formPod) {
        $key->content[] = $formData;
    }
}
$res->formData = $formData;
SaveJSON($res, $pods);

echo json_encode($res);

function SaveJSON($res, $pods) {
    if (count($pods) > 0) {
        if (file_put_contents('../../data/podcasts.json', json_encode($pods, JSON_PRETTY_PRINT))) {
            $res->success = true;
            $res->message = 'Gardado!';
        } else {
            $res->error = true;
            $res->message = 'Non se gardou...';
        }
    } else {
        $res->error = true;
        $res->message = 'Non se gardou...';
    }
}
?>
