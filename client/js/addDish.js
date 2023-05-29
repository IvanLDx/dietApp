import { $ } from './modules/dom.js';

const dishForm = '.js-add-dish';
const modifyDishForm = '.js-modify-form';
const removeDishForm = '.js-remove-dish-popup';

function hideModal() {
	$('.js-modify-modal').removeClass('activated');
}

function hidePopup() {
	$('.js-remove-popup').removeClass('activated');
}

function isFieldError(formData) {
	let error = false;
	if (!formData['dish-name']) {
		console.info('Engade o nome do prato!!');
		error = true;
	} else if (!formData['season']) {
		console.info('Engade unha tempada!');
		error = true;
	}
	return error;
}

function submitModifyForm(e) {
	submitForm(e, modifyDishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			hideModal();
		}
	});
}

function submitAddForm(e) {
	submitForm(e, dishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			$('.js-dish-name').val('');
			$('.js-season-radio').uncheck();
		}
	});
}

function submitRemoveForm(e) {
	submitForm(e, removeDishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			hidePopup();
		}
	});
}

function submitForm(e, form, { success }) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	formData.state = $form.state;

	e.preventDefault();
	if (!form.match('remove')) {
		if (isFieldError(formData)) return;
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

function openModifyDishModal(e) {
	let $dish = e.find('.js-dish-element-list');
	let dishID = $dish.attr('data-id');
	let dishName = $dish.attr('data-name');
	$('.js-dish-id').val(dishID);
	$('.js-dish-modify-name').val(dishName);

	let $modifyModal = $('.js-modify-modal');
	$modifyModal.addClass('activated');
	hidePopup();
	$('.js-dish-modify-name')[0].focus();
}

$(dishForm)[0].onsubmit = (e) => {
	submitAddForm(e);
};

$(modifyDishForm)[0].onsubmit = (e) => {
	submitModifyForm(e);
};

$(removeDishForm)[0].onsubmit = (e) => {
	submitRemoveForm(e);
};

document.onkeydown = (e) => {
	switch (e.key) {
		case 'Enter':
			if ($('.js-modify-modal').containsClass('activated')) {
				submitModifyForm(e);
			} else if ($('.js-remove-popup').containsClass('activated')) {
				submitRemoveForm(e);
			} else {
				submitAddForm(e);
			}
			break;
		case 'Escape':
			hideModal();
			hidePopup();
			break;
		default:
			break;
	}
};

$.click('.js-modify-dish', (e) => {
	openModifyDishModal(e);
});

$.click('.js-remove-dish', (e) => {
	let $dish = e.find('.js-dish-element-list');
	$('.js-remove-popup').addClass('activated');
	$('.js-dish-id-popup').val($dish.attr('data-id'));
});

$.click('.js-close-modal', () => {
	hideModal();
});

$.click('.js-close-popup', () => {
	hidePopup();
});
