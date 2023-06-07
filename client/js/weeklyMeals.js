import { $ } from './modules/dom.js';
import { formHelpers } from './weeklyMeals/formHelpers.js';

let generateCalendarForm = '.js-generate-calendar';

$(generateCalendarForm)[0].onsubmit = (e) => {
	formHelpers.submitGenerateTable(e, generateCalendarForm);
};

$.click('.js-locker', (e) => {
	let $dish = e.closest('.js-dish-element-list');
	$dish.classList.toggle('locked');
});

(() => {
	$('.js-dalle')[0].click();
})();
