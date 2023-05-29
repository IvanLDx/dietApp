import { chars } from './chars.js';

const TEXT_SPD = 4;
const DOT_SIZE = 1;
const DOT_WIDTH = 7;
const DOT_HEIGHT = 8;
let phrase = '';
const cv = document.querySelector('.js-cv-title');
const ctx = cv.getContext('2d');
cv.width = 345;
cv.height = DOT_SIZE * DOT_HEIGHT + (DOT_HEIGHT - 1);

const CharGrid = function () {
	this.w = DOT_WIDTH;
	this.h = DOT_HEIGHT;
	this.dot = { size: DOT_SIZE };
	this.paint = (phrase) => {
		ctx.clearRect(0, 0, cv.width, cv.height);
		ctx.fillStyle = '#da3';
		for (let i = 0; i < phrase.length; i++) {
			let key = phrase[i];
			this.char = chars[key];
			if (this.char) {
				this.fillCharBox(i);
			}
		}
	};
	this.fillCharBox = (i) => {
		for (let r = 0; r < this.h; r++) {
			for (let c = 0; c < this.w; c++) {
				if (this.char[r * this.w + c]) {
					ctx.fillRect(
						i * this.dot.size +
							i * this.w * this.dot.size +
							c * this.dot.size +
							c +
							this.w * i +
							this.dot.size,
						r * this.dot.size + r,
						this.dot.size,
						this.dot.size
					);
				}
			}
		}
	};
};

const grid = new CharGrid();

export const setTitle = (newPhrase) => {
	phrase = newPhrase;
};

export const title = {
	start: () => {
		phrase += phrase[0];
		phrase = phrase.substring(1);
		grid.paint(phrase);
		setTimeout(title.start, 1000 / TEXT_SPD);
	}
};
