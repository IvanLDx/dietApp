<div class="controls-box">
    <?php for ($i = 0; $i < 3; $i++) { ?>
        <h2 class="pod-name pod-name<?=$i+1?>">Podcast</h2>
    <?php } ?>

    <!-- AUDIO TITLE -->
    <div class="current-audio-title">
        <canvas class="cv-title js-cv-title"></canvas>
    </div>
    
    <div
        class="audio-container js-audio-container"
        data-current-episode-id="<?=$watchingPodcast->id?>"
        data-current-episode="<?="$watchingPodcast->name/$watchingPodcast->season/$watchingPodcast->episode"?>">

        <!-- HIDDEN AUDIO TOOL -->
        <div class="audio-wrapper">
            <audio controls volume="0">
                <!-- <source class="js-player-src" type="audio/mp3" src="audio/test/ramones.mp3"> -->
                <source class="js-player-src" type="audio/mp3">
            </audio>
        </div>

        <!-- FREQUENCY WAVES -->
        <div class="waves-wrapper">
            <canvas class="js-cv-frequency cv-frequency"></canvas>
            <canvas class="js-cv-frequency cv-frequency cv-frequency-bottom"></canvas>
        </div>

        <div class="time-numbers">
            <span class="time-numbers__current-time js-current-time">00:00</span>
             / 
            <span class="time-numbers__total-time js-total-time">00:00</span>
        </div>
        <div class="timer-bar">
            <div class="timer"></div>
        </div>

        <!-- CONTROLS -->
        <div class="controls">
            <div class="bookmark"></div>
            <div class="play-controls">
                <span></span>
                <button class="backward js-backward">
                    <img class="controls-img" src="./client/img/svg/controls/backward.svg" alt="">
                </button>
                <button class="play-pause" data-action="play">
                    <img class="controls-img play-img" src="./client/img/svg/controls/play.svg" alt="">
                    <img class="controls-img pause-img" src="./client/img/svg/controls/pause.svg" alt="">
                </button>
                <button class="forward js-forward">
                    <img class="controls-img" src="./client/img/svg/controls/forward.svg" alt="">
                </button>
                <span></span>
            </div>
            <div class="volume-container">
                <div class="volume-traces">
                    <div class="trace trace-1"><span></span></div>
                    <div class="trace trace-2"><span></span></div>
                    <div class="trace trace-3"><span></span></div>
                    <div class="trace trace-4"><span></span></div>
                    <div class="trace trace-5"><span></span></div>
                    <div class="trace trace-6"><span></span></div>
                    <div class="trace trace-7"><span></span></div>
                </div>

                <div class="volume-screw js-volume-screw">
                    <div class="volume-red">
                        <div class="volume-black js-volume-wheel">
                            <div class="volume-pointer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
