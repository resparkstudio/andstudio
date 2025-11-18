import gsap from 'gsap';
import { navigationSwiper } from './swipers';

/**
 * Replaces nav title and nav links after page change
 */
export function navScrollTransition() {
	const titleWrap = document.querySelector('[data-header-nav-transition="main-title-wrap"]');

	function navScrollTransitionHandler(newDoc) {
		const oldParentTitle = document.querySelector('[data-header-nav-transition="main-title"]');
		const newParentTitle = newDoc.querySelector('[data-header-nav-transition="main-title"]').cloneNode(true);
		const oldNavItems = document.querySelector('[data-nav-slider="wrap"]');
		const newNavItems = newDoc.querySelector('[data-nav-slider="wrap"]');

		// If old and new title missmatch, then we init nav transition
		if (oldParentTitle.textContent !== newParentTitle.textContent) {
			const timeline = createTransitionAnimation(oldParentTitle, newParentTitle, oldNavItems, newNavItems);

			// Execute nav transition when pages are fully switched
			document.addEventListener(
				'pageSwitched',
				() => {
					timeline.play();
				},
				{ once: true }
			);
		}
	}

	function createTransitionAnimation(oldParentTitle, newParentTitle, oldNavItems, newNavItems) {
		newParentTitle.classList.add('translate-y-full', 'absolute', 'top-0', 'bottom-0');
		titleWrap.append(newParentTitle);

		gsap.set(newNavItems, {
			width: oldNavItems.offsetWidth,
		});

		let tl = gsap.timeline({ paused: true });
		tl.to(oldNavItems, {
			autoAlpha: 0,
			duration: 0.3,
			ease: 'smooth',
			onComplete: () => {
				oldNavItems.replaceWith(newNavItems);
				navigationSwiper();
			},
		});

		// 1. Update titleWrap width to match the new title
		tl.to(titleWrap, {
			width: newParentTitle.offsetWidth,
			duration: 0.3,
			ease: 'smooth',
		});
		// 2. Rotate the titles
		tl.to(
			oldParentTitle,
			{
				yPercent: -100,
				duration: 0.6,
				ease: 'smooth',
				onComplete: () => {
					// 3. Remove old title on complete
					gsap.set(newParentTitle, {
						position: 'static',
					});
					oldParentTitle.remove();
				},
			},
			'<'
		).to(
			newParentTitle,
			{
				y: 0,
				duration: 0.6,
				ease: 'smooth',
			},
			'<'
		);

		return tl;
	}

	// Prepare for nav update if parent titles missmatch
	document.addEventListener('pageLoaded', (e) => {
		navScrollTransitionHandler(e.detail.newDoc);
	});
}
