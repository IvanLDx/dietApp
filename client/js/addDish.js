import { $ } from './modules/dom.js';

const $dishForm = $('.dish-add');

function submitForm(e) {
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
			if (res.success) {
				console.info(res.message);

				$.ajax({
					url: $dishForm.url,
					data: { state: 'RefreshList' },
					success: (res) => {
						$('.js-dish-list').html(res);
						$('.js-dish-name').val('');
					}
				});
			} else {
				console.info(res);
			}
		}
	});
}

$dishForm[0].onsubmit = (e) => {
	submitForm(e);
};

document.onkeydown = (e) => {
	switch (e.key) {
		case 'Enter':
			submitForm(e);
			break;
		default:
			break;
	}
};
