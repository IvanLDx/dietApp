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

function submitReplaceForm(params) {
	let data = {
		firstSelectedDish: JSON.stringify({
			id: params.$firstSelectedDish.attr('data-id'),
			pos: params.$firstSelectedDish.attr('data-position')
		}),
		secondSelectedDish: JSON.stringify({
			id: params.$secondSelectedDish.getAttribute('data-id'),
			pos: params.$secondSelectedDish.getAttribute('data-position')
		}),
		url: params.data.url,
		state: params.data.state
	};

	$.ajax({
		url: data.url,
		data: data,
		success: (res) => {
			$('.js-table-list').html(res);
		}
	});
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

formHelpers.submitModifyDish = function (e, form) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	[formData.url, formData.state] = $form
		.attr('data-action-modify-dish')
		.split('-');
	serializeSeasons(formData);

	let dish = e.closest('.js-dish-element-list');
	formData.dishID = dish.getAttribute('data-id');
	formData.dishPos = dish.getAttribute('data-position');

	$.ajax({
		url: formData.url,
		data: formData,
		success: (res) => {
			if (res.success) {
				let $dishName = dish.querySelector('.js-dish-element-name');
				$dishName.textContent = res.newDish.name;
				dish.setAttribute('data-id', res.newDish.id);
				dish.setAttribute('data-name', res.newDish.name);
				dish.setAttribute('data-tags', res.newDish.tags);
			}
		}
	});
};

formHelpers.submitSwapDishes = function (e, form) {
	let params = {
		$firstSelectedDish: $('.selected-to-swap'),
		$secondSelectedDish: e.closest('.js-dish-element-list'),
		data: {}
	};
	let $form = $(form);
	[params.data.url, params.data.state] = $form
		.attr('data-action-swap-dishes')
		.split('-');

	submitReplaceForm(params);
};

formHelpers.submitCopyDish = function (e, form) {
	let params = {
		$firstSelectedDish: $('.selected-to-copy'),
		$secondSelectedDish: e.closest('.js-dish-element-list'),
		data: {}
	};
	let $form = $(form);
	[params.data.url, params.data.state] = $form
		.attr('data-action-copy-dish')
		.split('-');

	submitReplaceForm(params);
};
