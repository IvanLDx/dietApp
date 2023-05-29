import { ajax } from './ajax.js';
import * as title from '../components/title.js';
import { $ } from './dom.js';
import { episodeList } from '../components/episodeList.js';

export default Audio = (VOLUME, SPEED) => {
	let self = document.querySelector('audio');

	self.bar = document.querySelector('.timer-bar');
	self.bar.click = (evt) => {
		self.bar.addEventListener('click', (e) => evt(e));
	};
	self.container = document.querySelector('.js-audio-container');
	self.playerSrc = document.querySelector('.js-player-src');
	self.timeline = document.querySelector('.timer');
	self.timeDisplay = {
		current: document.querySelector('.js-current-time'),
		total: document.querySelector('.js-total-time')
	};
	if (VOLUME) {
		self.volume = VOLUME;
	}
	if (SPEED) {
		self.playbackRate = SPEED;
	}

	self.playAction = (e) => {
		e.attr('data-action', 'pause');
		self.play();
	};

	self.setTotalTime = () => {
		self.timeDisplay.total.textContent = self.getFormattedTime(
			self.duration
		);
	};

	self.isPlaying = () => {
		return $('.play-pause')[0].attr('data-action') === 'pause';
	};

	self.pauseAction = (e) => {
		e.attr('data-action', 'play');
		self.pause();
	};

	let barWidth = self.bar.clientWidth;
	self.updateWidth = () => {
		self.width = (self.currentTime * barWidth) / self.duration;
		self.timeline.style.width = self.width + 'px';
	};

	self.getCurrentTime = (currentTime) => {
		let minutes = Math.floor(currentTime / 60);
		let seconds = Math.floor(currentTime % 60);
		if (seconds < 10) {
			seconds = '0' + seconds;
		}
		return minutes + ':' + seconds;
	};

	self.getCurrentEpisode = () => {
		return self.container.getAttribute('data-current-episode');
	};

	self.getEpisodeListElement = () => {
		let episodeID = self.container.getAttribute('data-current-episode-id');
		return document.querySelector(`[data-podcast-id="${episodeID}"]`);
	};

	self.getFormattedTime = (time) => {
		let currentTime = Math.floor(time);

		if (isNaN(time)) {
			return '00:00';
		}

		if (currentTime < 10) {
			currentTime = '00:0' + currentTime;
		} else if (currentTime < 60) {
			currentTime = '00:' + currentTime;
		} else if (currentTime < 600) {
			currentTime = '0' + self.getCurrentTime(currentTime);
		} else {
			currentTime = self.getCurrentTime(currentTime);
		}

		return currentTime;
	};

	self.updateDisplayTime = () => {
		let formattedTime = self.getFormattedTime(self.currentTime);
		self.timeDisplay.current.textContent = formattedTime;
	};

	self.selectTimeLine = (mouseX) => {
		self.currentTime = (mouseX * self.duration) / barWidth;
		self.updateWidth();
		self.updateDisplayTime();
	};

	self.ajaxSelectNextEpisode = () => {
		ajax({
			url: 'selectEpisode',
			data: {
				action: 'nextEpisode',
				episode: self.getCurrentEpisode()
			},
			success: (res) => {
				if (res.success) {
					self.selectNextEpisode(res);
				}
			}
		});
	};

	self.ajaxSelectPreviousEpisode = () => {
		ajax({
			url: 'selectEpisode',
			data: {
				action: 'previousEpisode',
				episode: self.getCurrentEpisode()
			},
			success: (res) => {
				if (res.success) {
					self.selectNextEpisode(res);
				}
			}
		});
	};

	self.ajaxSelectSelectedEpisode = (episode) => {
		ajax({
			url: 'selectEpisode',
			data: {
				action: 'selectedEpisode',
				episode: episode
			},
			success: (res) => {
				if (res.success) {
					self.selectNextEpisode(res);
				}
			}
		});
	};

	self.selectNextEpisode = (res) => {
		let episodeFormatted = res.episode.id.replaceAll('-', '/');
		episodeFormatted = episodeFormatted.replaceAll('_', '/');
		self.container.setAttribute('data-current-episode', episodeFormatted);

		self.container.setAttribute('data-current-episode-id', res.episode.id);

		self.setEpisode();
		self.setTotalTime();

		if (self.isPlaying()) {
			self.play();
		}
	};

	self.setEpisode = () => {
		var currentEpisode = self.getCurrentEpisode();
		self.playerSrc.src = `audio/${currentEpisode}.mp3`;
		self.load();

		episodeList.deselectEpisode();
		let $episode = episodeList.getEpisodeListElement(self.container);
		if ($episode) {
			title.setTitle($episode.getAttribute('data-full-title'));
			episodeList.selectEpisode($episode);
		}
		episodeList.scrollToEpisode();

		var waitForDataLoaded = setInterval(() => {
			if (self.readyState > 2) {
				self.setTotalTime();
				clearInterval(waitForDataLoaded);
			}
		}, 100);
	};

	return self;
};
