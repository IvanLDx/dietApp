import { $ } from './modules/dom.js';
import { formHelpers } from './weeklyMeals/formHelpers.js';

let generateCalendarForm = '.js-generate-calendar';

$(generateCalendarForm)[0].onsubmit = (e) => {
	e.preventDefault();
	formHelpers.submitGenerateTable(e, generateCalendarForm);
};
