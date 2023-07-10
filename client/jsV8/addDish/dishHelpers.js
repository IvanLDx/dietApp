export const dishHelpers = {
	createTagElement: (container, tag) => {
		let textColor = 'white-color';
		tag.classList.forEach((className) => {
			if (className.match('black-color')) textColor = className;
		});
		container.createInnerElement('LI', {
			class: 'tag-element js-tag-in-dish ' + textColor,
			text: tag.getAttribute('data-name'),
			color: tag.style.backgroundColor,
			attr: [
				{
					key: 'data-id',
					val: tag.getAttribute('data-id')
				},
				{
					key: 'style',
					val: 'background-color: ' + tag.style['background-color']
				}
			]
		});
	}
};
