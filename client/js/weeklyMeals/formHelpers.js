export const formHelpers = {};

formHelpers.submitGenerateTable = function (e, form) {
	let formData = $.ajax.serialize(form);
	let $form = $(form);
	formData.state = $form.state;

	e.preventDefault();
	$.ajax({
		url: $form.url,
		data: formData,
		success: (res) => {
			console.info(res);
		}
	});
};
