import { loop } from '../modules/helpers.js';

const WAVE_SIZE = 256;

let $audio = document.querySelector('audio');
const canvas = document.querySelectorAll('.js-cv-frequency');
loop(canvas, (cv) => (cv.width = cv.parentElement.clientWidth));
const canvasCtx = [canvas[0].getContext('2d'), canvas[1].getContext('2d')];
const audioCtx = new AudioContext();
const audioSourceNode = audioCtx.createMediaElementSource($audio);
const analyserNode = audioCtx.createAnalyser();
analyserNode.fftSize = WAVE_SIZE;

audioSourceNode.connect(analyserNode);
analyserNode.connect(audioCtx.destination);
let frequencyBars = new Uint8Array(analyserNode.frequencyBinCount);

function cvLoop(evt) {
	loop(canvasCtx, (ctx) => evt(ctx));
}

function Bar(i) {
	let self = {
		x: (canvas[0].width * i * 2) / frequencyBars.length,
		w: canvas[0].width / frequencyBars.length,
		h: -frequencyBars[i] * 0.7
	};
	self.paint = () => {
		loop(canvasCtx, (ctx) => {
			ctx.fillStyle = 'rgb(' + ~~frequencyBars[i] + ', 50, 50)';
			ctx.fillRect(self.x, canvas[0].height, self.w, self.h);
		});
	};
	return self;
}

function getWaves() {
	analyserNode.getByteFrequencyData(frequencyBars);
	cvLoop((cv) => cv.clearRect(0, 0, canvas[0].width, canvas[0].height));

	for (var i = 0; i < frequencyBars.length; i++) {
		Bar(i).paint();
	}
}

export const start = () => {
	requestAnimationFrame(start);
	getWaves();
};
