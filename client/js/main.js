import { $ } from './modules/dom.js';
import { MouseModel } from './modules/helpers.js';

const PAGE_CLASS_NAME = 'js-page page';
const MOVE_MIN_DISTANCE = 50;
const movementPos = new MouseModel();
const clickPos = new MouseModel();
const actionPos = new MouseModel();

let $page = $('.js-page');

const mouseEvts = {
	mousemove: function (e) {
		e.preventDefault();
		movementPos.set(e);
	},
	mouseup: function (e) {
		e.preventDefault();
		actionPos.getTotal(movementPos, clickPos);

		document.onmousemove = null;
		document.onmouseup = null;
	}
};

document.onmousedown = function (e) {
	clickPos.set(e);
	movementPos.set(e);
	$page.attr('class', PAGE_CLASS_NAME);
	$page.addClass('dish-list-active');

	document.onmousemove = (e) => mouseEvts.mousemove(e);
	document.onmouseup = (e) => mouseEvts.mouseup(e);
};
