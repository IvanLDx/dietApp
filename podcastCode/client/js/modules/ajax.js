/**
 * AJAX for PHP helpers
 * @param {object} obj ajax object
 * @param {function} loading data while requesting
 * @param {function} success data after request
 * @param {string} method send method
 * @param {string} url PHP file helper's name
 * @param {string} data client side request
 */
export const ajax = function ajax(obj) {
	obj.loading && obj.loading(obj);
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function (e) {
		this.readyState == 4 &&
			(obj.success && obj.success(JSON.parse(e.target.response)),
			obj.raw && obj.raw(e.target));
	};

	var completeURL = `helpers/${obj.url}.php`;

	var params = (o) => {
		let urlParams = '';
		for (let i = 0; i < Object.keys(o).length; i++) {
			urlParams += i == 0 ? '?' : '&';
			urlParams += Object.keys(o)[i] + '=';
			urlParams += Object.values(o)[i];
		}
		return urlParams;
	};

	var postParams = (o) => {
		let urlParams = '';
		for (let i = 0; i < Object.keys(o).length; i++) {
			urlParams += i == 0 ? '' : '&';
			urlParams += Object.keys(o)[i] + '=';
			urlParams += Object.values(o)[i];
		}
		return urlParams;
	};

	var objParams = obj.data ? obj.data : '';
	completeURL += params(objParams);

	ajax.open(obj.method, completeURL, true);
	if (obj.method === 'POST') {
		ajax.setRequestHeader(
			'Content-Type',
			'application/x-www-form-urlencoded'
		);
		ajax.send(postParams(obj.data));
	} else {
		ajax.send();
	}
};

ajax.serialize = (name) => {
	let form = new FormData(document.querySelector(name));
	let obj = {};
	for (var key of form.keys()) {
		obj[key] = form.get(key);
	}
	return obj;
};
