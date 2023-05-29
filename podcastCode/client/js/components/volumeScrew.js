import Audio from '../modules/Audio.js';

const $screw = document.querySelector('.js-volume-screw');
const $wheel = document.querySelector('.js-volume-wheel');
let clickPos = 0;
let currentPos = 0;
let speed = 2.4;
let length = 67.5;
let rotate = length;

function setAudioVolume() {
	let maxVolume = length * 2;
	let rawVolume = rotate + length;
	let relativeVolume = (rawVolume * 100) / maxVolume;
	let absVolume = relativeVolume / 100;
	Audio().volume = absVolume;
}

function mouseMove(e) {
	let nextPos = e.clientX - currentPos + (e.clientX - clickPos) * speed;

	if (nextPos > length) nextPos = length;
	if (nextPos < -length) nextPos = -length;

	setAudioVolume();
	$wheel.style.transform = `rotate(${nextPos}deg)`;
	rotate = nextPos;
}

function removeEvents() {
	document.onmousemove = null;
	document.onmouseup = null;
}

function startDrag() {
	document.onmousemove = mouseMove;
	document.onmouseup = removeEvents;
}

const GetRotateStyle = function () {
	let rotateRaw = $wheel.style.transform;
	let rotate = rotateRaw.replace('rotate(', '');
	rotate = rotate.replace('deg)');
	rotate = parseInt(rotate, 10);
	return rotate;
};
GetRotateStyle.setRotate = function () {
	if (!isNaN(GetRotateStyle())) {
		rotate = GetRotateStyle();
	}
};

export const volumeScrew = {
	start: function () {
		$screw.onmousedown = (e) => {
			GetRotateStyle.setRotate();

			clickPos = e.clientX;
			currentPos = e.clientX - rotate;
			startDrag();
		};
	}
};
