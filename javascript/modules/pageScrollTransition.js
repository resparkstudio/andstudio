import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function pageScrollTransition() {
	window.addEventListener('popstate', () => {
		window.location.reload();
	});

	const content = document.querySelector('[data-scroll-transition="content"]');
	if (!content) return;

	// Append all content to this container
	const transitionContainer = document.querySelector('[data-scroll-transition="container"]');
	let newTitle = null;
	let eventData = {
		newDoc: null,
		newContent: null,
		parentPageChanged: null,
	};

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
				const pageSwitched = new CustomEvent('pageSwitched', {
					detail: eventData,
				});
				document.dispatchEvent(pageSwitched);
			},
		});
	}

	async function appendNextPage(url) {
		try {
			const response = await fetch(url);
			const html = await response.text();
			const parser = new DOMParser();
			const newDoc = parser.parseFromString(html, 'text/html');

			const newContent = newDoc.querySelector('[data-scroll-transition="content"]');

			if (!newContent) {
				throw new Error('Next container not found');
			}

			// Set page title var for pageSwitched event handler
			newTitle = newDoc.title;

			// Compare old and new title elements to determine if title changed
			const oldTitleElement = document.querySelector('[data-header-nav-transition="main-title"]');
			const newTitleElement = newDoc.querySelector('[data-header-nav-transition="main-title"]');
			const parentPageChanged = oldTitleElement?.textContent?.trim() !== newTitleElement?.textContent?.trim();

			// Update event data
			eventData.newDoc = newDoc;
			eventData.newContent = newContent;
			eventData.parentPageChanged = parentPageChanged;

			// Append new content to container
			transitionContainer.append(newContent);

			// Dispatch event to re-init JS for new elements
			const pageLoaded = new CustomEvent('pageLoaded', {
				detail: eventData,
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
