export const episodeList = {
	getSelectedEpisode: () => {
		return document.querySelector('.selected');
	},
	getEpisodeListElement: (container) => {
		let episodeID = container.getAttribute('data-current-episode-id');
		return document.querySelector(`[data-podcast-id="${episodeID}"]`);
	},
	deselectEpisode: () => {
		let $selectedEpisode = episodeList.getSelectedEpisode();
		if ($selectedEpisode) {
			$selectedEpisode.classList.remove('selected');
		}
	},
	selectEpisode: ($episode) => {
		$episode.classList.add('selected');
	},
	scrollToEpisode: () => {
		let $episodesList = document.querySelector('.episodes-list');
		let currentEpisode = episodeList.getSelectedEpisode();
		let previousEpisode = currentEpisode.previousElementSibling;
		if (!previousEpisode) {
			previousEpisode = currentEpisode;
		}
		$episodesList.scrollTo({
			top: previousEpisode.offsetTop - 16,
			behavior: 'smooth'
		});
	}
};
