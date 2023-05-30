import { $ } from './modules/dom.js';
import { formHelpers } from './addDish/formHelpers.js';
import { modal, popup, tagModal } from './components/modals.js';
import * as tags from './components/tags.js';

const dishForm = '.js-add-dish';
const modifyDishForm = '.js-modify-form';
const removeDishForm = '.js-remove-dish-popup';

function keyEnterEvents(e) {
	let event = null;
	if ($('.js-modify-modal').containsClass('activated')) {
		event = 'modify-dish';
	} else if ($('.js-remove-popup').containsClass('activated')) {
		event = 'remove-dish';
	} else if ($('.js-tag-check')[0].checked) {
		event = 'remove-tag';
	} else {
		event = 'add-dish';
	}

	switch (event) {
		case 'add-dish':
			formHelpers.submitAddForm(e, dishForm);
			break;
		case 'modify-dish':
			formHelpers.submitModifyForm(e, modifyDishForm);
			break;
		case 'remove-dish':
			formHelpers.submitRemoveForm(e, removeDishForm);
			break;
		case 'remove-tag':
			$('.js-tag-submit')[0].click();
			break;
		default:
			break;
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
tags.removeTag();

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

$.click('.js-season-inputs, .js-dish-name, .js-dish-element-list', (e) => {
	tagModal.hide();
});
