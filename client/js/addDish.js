import { $ } from './modules/dom.js';

const $dishForm = $('.js-add-dish');
const $modifyDishForm = $('.js-modify-form');

function submitModifyForm(e) {
	submitForm(e, '.js-modify-form', {
		success: (res) => {
			$('.js-dish-list').html(res);
			$('.js-modify-modal').removeClass('activated');
		}
	});
}

function submitAddForm(e) {
	submitForm(e, '.js-add-dish', {
		success: (res) => {
			$('.js-dish-list').html(res);
			$('.js-dish-name').val('');
		}
	});
}

function submitForm(e, form, { success }) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	formData.state = $form.state;

	e.preventDefault();
	if (!formData['dish-name']) {
		console.info('Engade o nome do prato!!');
		return;
	}
	$.ajax({
		url: $form.url,
		data: formData,
		success: (res) => {
			if (res.success) {
				$.ajax({
					url: $form.url,
					data: { state: 'RefreshList' },
					success: (res) => {
						success(res);
					}
				});
			}
		}
	});
}

$dishForm[0].onsubmit = (e) => {
	submitAddForm(e);
};

$modifyDishForm[0].onsubmit = (e) => {
	submitModifyForm(e);
};

document.onkeydown = (e) => {
	switch (e.key) {
		case 'Enter':
			if ($('.js-modify-modal').containsClass('activated')) {
				submitModifyForm(e);
			} else {
				submitAddForm(e);
			}
			break;
		default:
			break;
	}
};

$.click('.js-modify-dish', (e) => {
	let $dish = e.find('.js-dish-element-list');
	let dishID = $dish.attr('data-id');
	let dishName = $dish.attr('data-name');
	$('.js-dish-id').val(dishID);
	$('.js-dish-modify-name').val(dishName);

	let $modifyModal = $('.js-modify-modal');
	$modifyModal.addClass('activated');
});

$.click('.js-close-modal', (e) => {
	$('.js-modify-modal').removeClass('activated');
});
