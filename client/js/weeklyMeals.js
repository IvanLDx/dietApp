import { $ } from './modules/dom.js';
import { formHelpers } from './weeklyMeals/formHelpers.js';
import { popup } from './components/modals.js';

let generateCalendarForm = '.js-generate-calendar';

$(generateCalendarForm)[0].onsubmit = (e) => {
	formHelpers.submitGenerateTable(e, generateCalendarForm);
};

$.click('.js-locker', (e) => {
	let $dish = e.closest('.js-dish-element-list');
	$dish.classList.toggle('locked');
});

$.click('.js-reset', () => {
	popup.show();
});

$.click('.js-close-popup', () => {
	popup.hide();
});

$('.js-remove-popup-form')[0].onsubmit = (e) => {
	e.preventDefault();
	let $lockedDishes = $('.js-dish-element-list.locked');
	$lockedDishes.removeClass('locked');
	$('.js-dalle')[0].click();
	popup.hide();
};

$.click('.js-refresh', (e) => {
	formHelpers.submitModifyDish(e, generateCalendarForm);
});

$.click('.js-swap', (e) => {
	let $selectedDish = e.closest('.js-dish-element-list');
	let state =
		$('.selected-to-swap').length === 0
			? 'selected-to-swap'
			: 'swap-with-selected';
	switch (state) {
		case 'selected-to-swap':
			$selectedDish.classList.add('selected-to-swap');
			$('.selected-to-copy').removeClass('selected-to-copy');
			break;
		case 'swap-with-selected':
			formHelpers.submitSwapDishes(e, generateCalendarForm);
			break;
		default:
			break;
	}
});

$.click('.js-copy', (e) => {
	let $selectedDish = e.closest('.js-dish-element-list');
	let state =
		$('.selected-to-copy').length === 0
			? 'selected-to-copy'
			: 'copy-selected';
	switch (state) {
		case 'selected-to-copy':
			$selectedDish.classList.add('selected-to-copy');
			$('.selected-to-swap').removeClass('selected-to-swap');
			break;
		case 'copy-selected':
			formHelpers.submitCopyDish(e, generateCalendarForm);
			break;
		default:
			break;
	}
});
