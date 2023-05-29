import Audio from '../modules/Audio.js';
import { $ } from '../modules/dom.js';

const SPEED = 3;
const VOLUME = 1;
const $audio = Audio(VOLUME, SPEED);

export const start = () => {
	$audio.setEpisode();
	timer();
};

const timer = () => {
	setTimeout(() => {
		$audio.updateWidth();
		$audio.updateDisplayTime();
		timer();
		if ($audio.currentTime >= $audio.duration) {
			$audio.currentTime = 0;
			$audio.ajaxSelectNextEpisode();
		}
	}, 1000 / SPEED);
};

$audio.bar.click((e) => {
	let targetRect = e.target.getBoundingClientRect();
	let mouseX = e.clientX - targetRect.left;

	$audio.selectTimeLine(mouseX);
});

$.click('.play-pause', (e) => {
	switch (e.attr('data-action')) {
		case 'play':
			$audio.playAction(e);
			break;
		case 'pause':
			$audio.pauseAction(e);
			break;
	}
});

$.click('.js-forward', (e) => {
	$audio.ajaxSelectNextEpisode();
});

$.click('.js-backward', (e) => {
	$audio.ajaxSelectPreviousEpisode();
});

$.click('.js-episode-listed', (e) => {
	$audio.ajaxSelectSelectedEpisode(e.attr('data-podcast-id'));
});
