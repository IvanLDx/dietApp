import { $ } from './modules/dom.js';

const $dishForm = $('.dish-add');

$dishForm[0].onsubmit = (e) => {
	let formData = $.ajax.serialize('.dish-add');
	formData.state = $dishForm.state;

	e.preventDefault();
	if (!formData['dish-name']) {
		console.info('Engade o nome do prato!!');
		return;
	}
	$.ajax({
		url: $dishForm.url,
		data: formData,
		success: (res) => {
			console.info(res);
		}
	});
};
