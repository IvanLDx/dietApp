import { $ } from '../modules/dom.js';
import { modal, popup } from '../components/modals.js';

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
			console.info(res);
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

export const formHelpers = {};
formHelpers.submitAddForm = function (e, dishForm) {
	submitForm(e, dishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			$('.js-dish-name').val('');
			$('.js-season-radio').uncheck();
		}
	});
};

formHelpers.submitModifyForm = function (e, modifyDishForm) {
	submitForm(e, modifyDishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			modal.hide();
		}
	});
};

formHelpers.submitRemoveForm = function (e, removeDishForm) {
	submitForm(e, removeDishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			popup.hide();
		}
	});
};
