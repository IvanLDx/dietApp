import { $ } from '../modules/dom.js';
import { formHelpers } from '../addDish/formHelpers.js';
import { popup } from './modals.js';

function submitTag() {
	$.click('.js-tag-submit', () => {
		$('.js-tag-name-destination').val($('.js-tag-name-source').val());
		$('.js-tag-color-destination').val($('.js-tag-color-source').val());
		$('.js-tag-submit-destination')[0].click();
	});
}

function openTagsModal() {
	$.click('.js-open-tag-modal', () => {
		popup.hide();
	});
}

$('.js-add-tag')[0].onsubmit = (e) => {
	e.preventDefault();
	formHelpers.submitTagForm(e, '.js-add-tag');
};

export { submitTag, openTagsModal };
