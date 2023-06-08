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

	e.preventDefault();
	$.ajax({
		url: $form.url,
		data: formData,
		success: (res) => {
			$('.js-table-list').html(res);
		}
	});
};
