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
		selves.forEach((self) => {
			self.addEventListener('click', () => {
				evt(self);
			});
		});
	};

	selves.on = (listener, evt) => {
		selves.forEach((self) => {
			self.addEventListener(listener, (e) => {
				evt(e);
			});
		});
	};

	selves.attr = (attr, val) => {
		selves.forEach((self) => {
			self.attr(attr, val);
		});
	};

	selves.val = (val) => {
		selves.forEach((self) => {
			self.val(val);
		});
	};

	selves.addClass = (val) => {
		selves.forEach((self) => {
			self.addClass(val);
		});
	};

	selves.containsClass = (val) => {
		let containsThisClass = false;
		selves.forEach((self) => {
			containsThisClass = self.containsClass(val);
		});
		return containsThisClass;
	};

	selves.removeClass = (val) => {
		selves.forEach((self) => {
			self.removeClass(val);
		});
	};

	selves.css = (key, val) => {
		selves.forEach((self) => {
			if (val) {
				self.style[key] = val;
			} else {
				return self.style[key];
			}
		});
	};

	selves.loadAudio = (id) => {
		selves.forEach((self) => {
			self.src = `audio/asefemeridas/${id}.mp3`;
			let audio = self.parentElement;
			audio.load();
			audio.play();

			getElapsedTime(audio);
		});
	};

	selves.html = (val) => {
		selves.forEach((self) => {
			self.innerHTML = val;
		});
	};

	selves.uncheck = () => {
		selves.forEach((self) => {
			self.uncheck();
		});
	};
	if (selves[0]) {
		switch (selves[0].nodeName) {
			case 'FORM':
				[selves.url, selves.state] =
					selves[0].attributes.action.value.split('-');
				break;
			default:
				break;
		}
	}

	selves.forEach((self) => {
		$.selfFunctions(self);
	});

	return selves;
};

$.selfFunctions = (self) => {
	if (!self) return;

	self.getID = () => self.dataset?.id;
	self.getAudioUrl = () => self.dataset?.season + '/' + self.dataset?.episode;
	self.html = (val) => (self.innerHTML = val);
	self.addClass = (val) => self.classList.add(val);
	self.containsClass = (val) => {
		return self.classList.contains(val);
	};
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
	self.uncheck = () => {
		self.checked = false;
	};
	self.find = (name) => {
		let closest = self.closest(name);
		$.selfFunctions(closest);
		return closest;
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

/**
 * AJAX for PHP helpers
 * @param {object} obj ajax object
 * @param {function} loading data while requesting
 * @param {function} success data after request
 * @param {string} method send method
 * @param {string} url PHP file helper's name
 * @param {string} data client side request
 */
$.ajax = (obj) => {
	if (obj.loading) {
		obj.loading(obj);
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function (e) {
		if (this.readyState === 4) {
			try {
				obj.success(JSON.parse(e.target.response), 'json');
			} catch (err) {
				obj.success(e.target.response, 'text');
			}
		}
	};

	var completeURL = `server/helpers/${obj.url}.php`;

	var params = (o) => {
		let urlParams = '';
		let symbol = obj.method === 'POST' ? '' : '?';
		for (let i = 0; i < Object.keys(o).length; i++) {
			urlParams += i == 0 ? symbol : '&';
			urlParams += Object.keys(o)[i] + '=';
			urlParams += Object.values(o)[i];
		}
		return urlParams;
	};

	var objParams = obj.data ? obj.data : '';
	completeURL += params(objParams);

	ajax.open(obj.method, completeURL, true);
	switch (obj.method) {
		case 'POST':
			ajax.setRequestHeader(
				'Content-Type',
				'application/x-www-form-urlencoded'
			);
			ajax.send(params(obj.data));
			break;
		default:
			ajax.send();
			break;
	}
};

$.ajax.serialize = (name) => {
	let form = new FormData(document.querySelector(name));
	let obj = {};
	for (var key of form.keys()) {
		obj[key] = form.get(key);
	}
	return obj;
};
