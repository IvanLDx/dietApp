import { ajax } from './modules/ajax.js';
import { $ } from './modules/dom.js';
import { title } from './components/title.js';
import * as controls from './components/controls.js';
import * as frequency from './components/frequencyWave.js';
import { volumeScrew } from './components/volumeScrew.js';
import Audio from './modules/Audio.js';

// var pods = $('.js-pods');
// pods.click((e) => {
// 	ajax({
// 		url: 'getEpisodes',
// 		method: 'GET',
// 		data: { id: e.getID() },
// 		raw: (data) => {
// 			$('.js-player-list').html(data.response);
// 		}
// 	});
// });

// $.click('.js-player-li', (e) => {
// 	let $audioTag = $('.js-player-src');
// 	$audioTag.loadAudio(e.getAudioUrl());
// });

$.click('.js-vinyl:not(.selected)', (e) => {
	$('.js-vinyl.selected').removeClass('selected');
	$('.opened-vinyl').addClass('keep-the-vinyl-in-its-box');
	$('.opened-vinyl').removeClass('opened-vinyl');
	let vinyl = e.find('.vinyl');
	vinyl.addClass('animate-take-the-vinyl-out');
	setTimeout(() => {
		vinyl.addClass('opened-vinyl');
	}, 800);
	setTimeout(() => {
		vinyl.removeClass('animate-take-the-vinyl-out');
		$('.vinyl').removeClass('keep-the-vinyl-in-its-box');
	}, 1200);
	e.addClass('selected');
});

controls.start();
frequency.start();
volumeScrew.start();
title.start();
