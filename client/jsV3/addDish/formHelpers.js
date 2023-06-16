import { $ } from '../modules/dom.js';
import { modal, popup, tagModal } from '../components/modals.js';

function isFieldError(formData) {
	let error = false;
	if (!formData['dish-name']) {
		console.log('Engade o nome do prato!!');
		error = true;
	} else if (!formData['season']) {
		console.log('Engade unha tempada!');
		error = true;
	}
	return error;
}

function isFieldTagError(formData) {
	let error = false;
	if (!formData['tag-name']) {
		console.log('Engade o nome do prato!!');
		error = true;
	}
	return error;
}

function serializeTags(container) {
	let $tags = $(container + ' .js-tag-in-dish');

	let tagsString = '';
	$tags.forEach(($tag, i) => {
		if (i !== 0) {
			tagsString += ', ';
		}
		tagsString += $tag.attr('data-id');
	});

	return tagsString;
}

function submitForm(e, form, { success }) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	formData.state = $form.state;
	formData.date = new Date().toISOString().slice(0, 10);

	e.preventDefault();
	if (!form.match('remove')) {
		switch ($form.url) {
			case 'Dish':
				if (isFieldError(formData)) return;
				break;
			case 'Tag':
				if (isFieldTagError(formData)) return;
				formData['tag-color'] = formData['tag-color'].replace('#', '');
				break;
			default:
				break;
		}
	}

	$.ajax({
		url: $form.url,
		method: 'GET',
		data: formData,
		success: (res) => {
			if (res.success) {
				$.ajax({
					url: $form.url,
					method: 'GET',
					data: { state: 'RefreshList' },
					success: (res) => {
						success(res);
					}
				});
			} else {
				console.log(res.message);
			}
		}
	});
}

export const formHelpers = {};
formHelpers.submitAddForm = function (e, dishForm) {
	let tagsString = serializeTags('.js-add-dish');
	$('.js-tag-ids').val(tagsString);

	submitForm(e, dishForm, {
		success: (res) => {
			$('.js-dish-list').html(res);
			$('.js-dish-name').val('');
			$('.js-season-radio').uncheck();
			$('.js-tags').html('');
			tagModal.hide();
		}
	});
};

formHelpers.submitModifyForm = function (e, modifyDishForm) {
	let tagsString = serializeTags('.js-modify-modal');
	$('.js-modify-tag-ids').val(tagsString);

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

formHelpers.submitTagForm = function (e, removeTagForm) {
	submitForm(e, removeTagForm, {
		success: (res) => {
			$('.js-tag-container').html(res);
			$('.js-tags-modal-container').html(res);
			$('.js-tag-name-source').val('');
			$('.js-tag-color-source').val('');
			$('.js-tag-name-destination').val('');
			$('.js-tag-color-destination').val('');
		}
	});
};
