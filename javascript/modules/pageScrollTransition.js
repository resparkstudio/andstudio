import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function pageScrollTransition() {
	const content = document.querySelector(
		'[data-scroll-transition="content"]'
	);
	if (!content) return;

	// Append all content to this container
	const transitionContainer = document.querySelector(
		'[data-scroll-transition="container"]'
	);
	let newTitle;

	function removeOldContent(content) {
		content.remove();
		setTimeout(() => {
			ScrollTrigger.refresh();
		}, 50);
	}

	function updateBrowserState(nextPageUrl) {
		history.pushState({ url: nextPageUrl }, '', nextPageUrl);
		document.title = newTitle;
	}

	function createScrollTrigger(content) {
		const footer = content.querySelector('[data-next-page]');
		if (!footer) return;
		const nextPageUrl = footer.dataset.nextPage;

		ScrollTrigger.create({
			trigger: footer,
			start: 'top bottom',
			end: 'bottom top',
			once: true,
			onEnter: () => {
				appendNextPage(nextPageUrl);
			},
			onLeave: () => {
				removeOldContent(content);
				updateBrowserState(nextPageUrl);

				// Dispatch custom event when old page is removed
				const pageSwitched = new CustomEvent('pageSwitched');
				document.dispatchEvent(pageSwitched);
			},
		});
	}

	async function appendNextPage(url) {
		try {
			const response = await fetch(url);
			const html = await response.text();
			const parser = new DOMParser();
			const doc = parser.parseFromString(html, 'text/html');

			const newContent = doc.querySelector(
				'[data-scroll-transition="content"]'
			);

			if (!newContent) {
				throw new Error('Next container not found');
			}

			newTitle = doc.title;

			// Append new content to container
			transitionContainer.append(newContent);

			// Dispatch event to re-init JS for new elements
			const pageLoaded = new CustomEvent('pageLoaded', {
				detail: {
					container: newContent,
				},
			});
			document.dispatchEvent(pageLoaded);

			// Create scrollTrigger for new content
			createScrollTrigger(newContent);
		} catch (error) {
			console.error(error.message);
		}
	}

	// Create scrollTrigger on initial content
	createScrollTrigger(content);
}
