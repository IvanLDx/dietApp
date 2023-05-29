import { loop } from './helpers.js';

const SHOW_TRACE = false;

function getElapsedTime(audio) {
	setInterval(() => {
		console.info(
			~~(audio.currentTime / 60) +
				':' +
				Math.floor(audio.currentTime % 60)
		);
	}, 1000);
}

export const $ = function $(name) {
	let selves;
	if (typeof name === 'object') {
		selves = name;
	} else {
		selves = document.querySelectorAll(name);
	}

	if (selves.length === 0 && SHOW_TRACE) {
		console.trace(`$('${name}') doesn't exist.`);
	}

	selves.click = (evt) => {
		loop(selves, (self) => {
			self.addEventListener('click', () => {
				evt(self);
			});
		});
	};

	selves.on = (listener, evt) => {
		loop(selves, (self) => {
			self.addEventListener(listener, (e) => {
				evt(e);
			});
		});
	};

	selves.attr = (attr, val) => {
		loop(selves, (self) => {
			self.attr(attr, val);
		});
	};

	selves.val = (val) => {
		loop(selves, (self) => {
			self.val(val);
		});
	};

	selves.addClass = (val) => {
		loop(selves, (self) => {
			self.addClass(val);
		});
	};

	selves.containsClass = (val) => {
		loop(selves, (self) => {
			self.containsClass(val);
		});
	};

	selves.removeClass = (val) => {
		loop(selves, (self) => {
			self.removeClass(val);
		});
	};

	selves.css = (key, val) => {
		loop(selves, (self) => {
			if (val) {
				self.style[key] = val;
			} else {
				return self.style[key];
			}
		});
	};

	selves.loadAudio = (id) => {
		loop(selves, (self) => {
			self.src = `audio/asefemeridas/${id}.mp3`;
			let audio = self.parentElement;
			audio.load();
			audio.play();

			getElapsedTime(audio);
		});
	};

	selves.html = (val) => {
		loop(selves, (self) => {
			self.innerHTML = val;
		});
	};

	loop(selves, (self) => {
		$.selfFunctions(self);
	});

	return selves;
};

$.selfFunctions = (self) => {
	self.getID = () => self.dataset?.id;
	self.getAudioUrl = () => self.dataset?.season + '/' + self.dataset?.episode;
	self.html = (val) => (self.innerHTML = val);
	self.addClass = (val) => self.classList.add(val);
	self.containsClass = (val) => self.classList.contains(val);
	self.removeClass = (val) => self.classList.remove(val);
	self.attr = (attr, val) => {
		if (val) {
			self.setAttribute(attr, val);
		} else {
			return self.getAttribute(attr);
		}
	};
	self.val = (val) => {
		if (typeof val === 'string') {
			self.value = val;
		} else {
			return self.value;
		}
	};
	self.find = (name) => {
		return $(self.querySelectorAll(name));
	};
	return self;
};

$.click = function (el, evt) {
	document.querySelector('body').addEventListener('click', (e) => {
		let list = e.target.closest(el);
		if (!list) {
			let parent = e.target.parentElement;
			while (
				!parent.classList.contains(el) &&
				parent.nodeName !== 'HTML'
			) {
				parent = parent.parentElement;
			}

			list = parent;
		}
		if (list.nodeName === 'BODY' || list.nodeName === 'HTML') {
			return;
		}
		if (!list) return;
		$.selfFunctions(list);
		evt(list);
	});
};
