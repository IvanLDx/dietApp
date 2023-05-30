import { $ } from './modules/dom.js';
import { formHelpers } from './addDish/formHelpers.js';
import { modal, popup, tagModal } from './components/modals.js';
import * as tags from './components/tags.js';

const dishForm = '.js-add-dish';
const modifyDishForm = '.js-modify-form';
const removeDishForm = '.js-remove-dish-popup';

function keyEnterEvents(e) {
	if ($('.js-modify-modal').containsClass('activated')) {
		formHelpers.submitModifyForm(e, modifyDishForm);
	} else if ($('.js-remove-popup').containsClass('activated')) {
		formHelpers.submitRemoveForm(e, removeDishForm);
	} else {
		formHelpers.submitAddForm(e, dishForm);
	}
}

$(dishForm)[0].onsubmit = (e) => {
	formHelpers.submitAddForm(e, dishForm);
};

$(modifyDishForm)[0].onsubmit = (e) => {
	formHelpers.submitModifyForm(e, modifyDishForm);
};

$(removeDishForm)[0].onsubmit = (e) => {
	formHelpers.submitRemoveForm(e, removeDishForm);
};

tags.submitTag();
tags.openTagsModal();

document.onkeydown = (e) => {
	switch (e.key) {
		case 'Enter':
			keyEnterEvents(e);
			break;
		case 'Escape':
			modal.hide();
			popup.hide();
			tagModal.hide();
			break;
		default:
			break;
	}
};

$.click('.js-modify-dish', (e) => {
	modal.show(e);
});

$.click('.js-remove-dish', (e) => {
	popup.show(e);
});

$.click('.js-close-modal', () => {
	modal.hide();
});

$.click('.js-close-popup', () => {
	popup.hide();
});

$.click(
	'.js-season-inputs, .js-dish-name, .js-submit-dish, .js-dish-element-list',
	(e) => {
		console.info(e);
		tagModal.hide();
	}
);
