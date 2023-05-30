import { $ } from '../modules/dom.js';

function getDishData(e) {
	let $dish = e.parents('.js-dish-element-list');
	return {
		id: $dish.attr('data-id'),
		season: $dish.attr('data-season'),
		name: $dish.attr('data-name')
	};
}

export const modal = {
	hide: function () {
		$('.js-modify-modal').removeClass('activated');
	},
	show: function (e) {
		let dishData = getDishData(e);
		$('.js-dish-id').val(dishData.id);
		$('.js-dish-modify-name').val(dishData.name);

		let $season = $(
			`.js-modify-form .js-season-radio[value=${dishData.season}`
		);
		$season.check();
		let $modifyModal = $('.js-modify-modal');
		$modifyModal.addClass('activated');
		popup.hide();
		$('.js-dish-modify-name')[0].focus();
	}
};

export const popup = {
	hide: function () {
		$('.js-remove-popup').removeClass('activated');
	},
	show: function (e) {
		let dishData = getDishData(e);
		$('.js-dish-name-popup').txt(dishData.name);
		$('.js-remove-popup').addClass('activated');
		$('.js-dish-id-popup').val(dishData.id);
		$('.js-dish-season-popup').val(dishData.season);
	}
};

export const tagModal = {
	hide: function () {
		$('.js-tag-check').uncheck();
	}
};
