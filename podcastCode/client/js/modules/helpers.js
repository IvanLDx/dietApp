import { ajax } from './ajax.js';
export { ajax };

import { $ } from './dom.js';
export { $ };

export const loop = function loop(items, evt) {
	for (let i = 0; i < items.length; i++) {
		evt(items[i], i);
	}
};

export const helpers = {
	validateForm: (form) => {
		let inputs = $(form + ' input[data-required="true"');
		let result = {
			list: []
		};
		loop(inputs, (input) => {
			if (input.value.trim() === '') {
				result.error = true;
				input.closest('.input').classList.add('miss');
			}
		});
		return result;
	}
};
