import { $ } from '../modules/dom.js';
import { formHelpers } from '../addDish/formHelpers.js';
import { popup } from './modals.js';
import { dishHelpers } from '../addDish/dishHelpers.js';

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

function removeTag() {
	$.click('.js-accept-remove-tag', (e) => {
		let tagID = $('.js-confirm-remove-tag')[0].attr('data-id');
		let action = $('.js-tag-container')[0].attr('data-action');
		let [url, state] = action.split('-');

		$.ajax({
			url: url,
			method: 'GET',
			data: {
				state: state,
				'tag-id': tagID
			},
			success: (res) => {
				if (res.success) {
					$.ajax({
						url: url,
						method: 'GET',
						data: { state: 'RefreshList' },
						success: (res) => {
							$('.js-tag-container').html(res);
							showTagList();
						}
					});
				} else {
					console.log(res.message);
				}
			}
		});
	});
}

function selectTag($tagElement, tagModal) {
	let $tagContainer = $(tagModal);
	dishHelpers.createTagElement($tagContainer, $tagElement);
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

document.addEventListener('click', (e) => {
	let $removeTag = e.target.closest('.js-remove-tag');
	if ($removeTag) {
		$removeTag.click();
		return;
	}

	let $tagElement = e.target.closest('.js-tag-element-list');
	if ($tagElement) {
		let modifyTagModal = $tagElement.closest('.js-modify-modal')
			? '.js-dish-tags-modal'
			: '.js-tags';

		selectTag($tagElement, modifyTagModal);
	}
});

$.click('.js-tag-in-dish', (e) => {
	e.remove();
});

(() => {
	$('.js-tag-ids').val('');
})();

export { submitTag, openTagsModal, removeTag };
