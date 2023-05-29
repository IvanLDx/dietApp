<?php
$id = $_REQUEST['episode'];
$action = $_REQUEST['action'];

$account = json_decode(file_get_contents("../data/account.json"));
$pods = json_decode(file_get_contents("../data/podcasts.json"));
$res = new stdclass();
$success = false;

if ($action === 'nextEpisode') {
    for ($i = 0; $i < count($pods); $i++) {
        $pod = $pods[$i];
        for ($n = 0; $n < count($pod->content); $n++) {
            $episode = $pod->content[$n];
            if ($episode->id === $account->watchingPodcast[0]->id) {
                $m = $n + 1;
                if ($m < count($pod->content)) {
                    $podContent = $pod->content[$m];
                    $res->episode = $podContent;
                    $account->watchingPodcast[0]->season = intval($podContent->season);
                    $account->watchingPodcast[0]->episode = intval($podContent->episode);
                    $account->watchingPodcast[0]->id = $account->watchingPodcast[0]->name . "_" . $podContent->season . "-" . $podContent->episode;
                    $success = true;
                } else {
                    $res->finished = true;
                }
                break;
            }
        }
        if ($m !== null) {
            break;
        }
    }
} else if ($action === 'previousEpisode') {
    for ($i = 0; $i < count($pods); $i++) {
        $pod = $pods[$i];
        for ($n = 0; $n < count($pod->content); $n++) {
            $episode = $pod->content[$n];
            if ($episode->id === $account->watchingPodcast[0]->id) {
                $m = $n - 1;
                if ($m >= 0) {
                    $podContent = $pod->content[$m];
                    $res->episode = $podContent;
                    $account->watchingPodcast[0]->season = intval($podContent->season);
                    $account->watchingPodcast[0]->episode = intval($podContent->episode);
                    $account->watchingPodcast[0]->id = $account->watchingPodcast[0]->name . "_" . $podContent->season . "-" . $podContent->episode;
                    $success = true;
                } else {
                    $res->finished = true;
                }
                break;
            }
        }
        if ($m !== null) {
            break;
        }
    }
} else if ($action === 'selectedEpisode') {
    for ($i = 0; $i < count($pods); $i++) {
        $pod = $pods[$i];
        for ($n = 0; $n < count($pod->content); $n++) {
            $episode = $pod->content[$n];
            if ($episode->id === $id) {
                    $podContent = $pod->content[$n];
                    $res->episode = $podContent;
                    $account->watchingPodcast[0]->season = intval($podContent->season);
                    $account->watchingPodcast[0]->episode = intval($podContent->episode);
                    $account->watchingPodcast[0]->id = $account->watchingPodcast[0]->name . "_" . $podContent->season . "-" . $podContent->episode;
                    $success = true;
                    break;
            }
        }
    }
}

if ($account->watchingPodcast[0] && $success) {
    file_put_contents("../data/account.json", json_encode($account, JSON_PRETTY_PRINT));
    $res->success = true;
}

echo json_encode($res);
?>
