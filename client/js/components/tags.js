import { $ } from '../modules/dom.js';
import { formHelpers } from '../addDish/formHelpers.js';
import { popup } from './modals.js';

function showTagList() {
	$('.js-tag-container').addClass('listed');
}

function hideTagList() {
	$('.js-tag-container').removeClass('listed');
}

function submitTag() {
	$.click('.js-tag-submit', () => {
		$('.js-tag-name-destination').val($('.js-tag-name-source').val());
		$('.js-tag-color-destination').val($('.js-tag-color-source').val());
		$('.js-tag-submit-destination')[0].click();
	});
}

function openTagsModal() {
	$.click('.js-open-tag-modal', () => {
		popup.hide();
	});
}

$('.js-add-tag')[0].onsubmit = (e) => {
	e.preventDefault();
	formHelpers.submitTagForm(e, '.js-add-tag');
};

$.click('.js-remove-tag', (e) => {
	hideTagList();
	let tagName = e.parents('.js-tag-element-list').attr('data-name');
	$('.js-confirm-remove-tag-name').txt(tagName);

	let tagID = e.parents('.js-tag-element-list').attr('data-id');
	let $removeTagContainer = $('.js-confirm-remove-tag');
	$removeTagContainer.attr('data-id', tagID);
});

$.click('.js-cancel-remove-tag', () => {
	showTagList();
});

function removeTag() {
	$.click('.js-accept-remove-tag', (e) => {
		let tagID = $('.js-confirm-remove-tag')[0].attr('data-id');
		let action = $('.js-tag-container')[0].attr('data-action');
		let [url, state] = action.split('-');

		console.info($('.js-confirm-remove-tag'));
		$.ajax({
			url: url,
			data: {
				state: state,
				'tag-id': tagID
			},
			success: (res) => {
				if (res.success) {
					$.ajax({
						url: url,
						data: { state: 'RefreshList' },
						success: (res) => {
							$('.js-tag-container').html(res);
							showTagList();
						}
					});
				} else {
					console.info(res.message);
				}
			}
		});
	});
}

export { submitTag, openTagsModal, removeTag };
