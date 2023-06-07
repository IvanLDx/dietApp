import { $ } from '../modules/dom.js';

function serializeSeasons(formData) {
	let selectedSeasons = [];
	if (formData['season-summer']) {
		selectedSeasons = [...selectedSeasons, 'summer'];
	}

	if (formData['season-winter']) {
		selectedSeasons = [...selectedSeasons, 'winter'];
	}

	if (formData['season-halftime']) {
		selectedSeasons = [...selectedSeasons, 'halftime'];
	}
	formData.seasons = selectedSeasons;
}

export const formHelpers = {};
formHelpers.submitGenerateTable = function (e, form) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	formData.state = $form.state;
	serializeSeasons(formData);

	let lockedDishes = [];
	let $lockedDishes = $('.js-dish-element-list');
	$lockedDishes.forEach(($dish, i) => {
		if ($dish.classList.contains('locked')) {
			lockedDishes.push({
				pos: i,
				id: $dish.attr('data-id'),
				name: $dish.attr('data-name'),
				tags: $dish.attr('data-tags')
			});
		}
	});

	formData.lockedDishes = JSON.stringify(lockedDishes);

	e.preventDefault();
	$.ajax({
		url: $form.url,
		data: formData,
		success: (res) => {
			$('.js-table-list').html(res);
		}
	});
};
