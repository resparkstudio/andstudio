/**
 * Used for desktop top nav and anchor nav
 */
import gsap from 'gsap';

export function overflowNavigation() {
	return;
	const visibleCount = 5;
	const overflowNavTargets = document.querySelectorAll(
		'[data-nav-slider="target"]'
	);
	if (!overflowNavTargets.length) return;

	overflowNavTargets.forEach((target) => {
		const navContainer = target.querySelector(
			'[data-nav-slider="container"]'
		);
		const prevButton = target.querySelector('.swiper-button-prev');
		const nextButton = target.querySelector('.swiper-button-next');

		const navWrap = target.querySelector('[data-nav-slider="wrap"]');
		const navLinks = navWrap.querySelectorAll('[data-nav-slider="item"]');

		let currentStartIndex = 0;

		function adjustNavWidth(instant = false) {
			// Max width = container width - wrap padding width
			const maxWidth =
				target.offsetWidth -
				(navContainer.offsetWidth - navWrap.offsetWidth);

			let navItemsWidth = 0;
			const startIndex = Math.min(
				currentStartIndex,
				navLinks.length - visibleCount
			);
			const endIndex = Math.min(
				startIndex + visibleCount,
				navLinks.length
			);

			// Add all visible link widths
			for (let i = startIndex; i < endIndex; i++) {
				navItemsWidth += navLinks[i].offsetWidth;
			}

			// Add gaps
			const visibleItemCount = endIndex - startIndex;
			navItemsWidth += (visibleItemCount - 1) * 32;

			const finalWidth = Math.min(navItemsWidth, maxWidth);

			gsap.to(navWrap, {
				width: finalWidth,
				duration: instant ? 0 : 0.6,
				ease: 'custom',
				overwrite: true,
			});
		}

		function scrollToIndex(index, behavior = 'smooth', inline = 'start') {
			const targetLink = navLinks[index];
			if (!targetLink) return;

			// Calculate new width
			const maxWidth =
				target.offsetWidth -
				(navContainer.offsetWidth - navWrap.offsetWidth);
			let navItemsWidth = 0;
			const startIndex = Math.min(
				currentStartIndex,
				navLinks.length - visibleCount
			);
			const endIndex = Math.min(
				startIndex + visibleCount,
				navLinks.length
			);

			for (let i = startIndex; i < endIndex; i++) {
				navItemsWidth += navLinks[i].offsetWidth;
			}
			navItemsWidth += (endIndex - startIndex - 1) * 32;
			const finalWidth = Math.min(navItemsWidth, maxWidth);

			// targetLink.scrollIntoView({
			// 	behavior: 'smooth',
			// 	block: 'nearest',
			// 	inline: inline,
			// });

			// Animate width with continuous scroll updates
			gsap.to(navWrap, {
				width: finalWidth,
				duration: behavior === 'instant' ? 0 : 0.2,
				ease: 'custom',
				overwrite: true,
				onUpdate: () => {
					targetLink.scrollIntoView({
						behavior: 'smooth',
						block: 'nearest',
						inline: inline,
					});
				},
			});
		}

		function isNavLinkVisible(activeIndex) {
			const link = navLinks[activeIndex];

			const wrapRect = navWrap.getBoundingClientRect();
			const linkRect = link.getBoundingClientRect();

			return (
				linkRect.left >= wrapRect.left - 1 &&
				linkRect.right <= wrapRect.right + 1
			);
		}

		function getLastVisibleIndex() {
			for (let i = navLinks.length - 1; i >= 0; i--) {
				if (isNavLinkVisible(i)) {
					return i;
				}
			}
			return 0;
		}

		function getFirstVisibleIndex() {
			for (let i = 0; i < navLinks.length; i++) {
				if (isNavLinkVisible(i)) {
					return i;
				}
			}
			return 0;
		}

		function getActiveLinkIndex() {
			const activeLink =
				navWrap.querySelector('.is-current')?.parentElement;
			if (!activeLink) {
				return 0;
			} else {
				return (activeNavIndex =
					Array.from(navLinks).indexOf(activeLink));
			}
		}

		nextButton.addEventListener('click', () => {
			// Check if last visible is not last nav link
			const lastVisibleIndex = getLastVisibleIndex();
			if (lastVisibleIndex < navLinks.length - 1) {
				const nextIndex = lastVisibleIndex + 1;

				// Get previous 4 items
				currentStartIndex = Math.max(nextIndex - (visibleCount - 1), 0); // Move this to scrollToIndex
				scrollToIndex(nextIndex, 'smooth', 'end');
			}
		});

		prevButton.addEventListener('click', () => {
			// Move backward by 1
			const firstVisibleIndex = getFirstVisibleIndex();
			if (firstVisibleIndex > 0) {
				scrollToIndex(firstVisibleIndex - 1, 'smooth', 'start');
			}
		});

		window.addEventListener('resize', () => {
			adjustNavWidth();
		});

		// 1. nitial width adjustment
		adjustNavWidth(true);
		// 2. Check if active link is visible and scroll to it if not
		if (!isNavLinkVisible(getActiveLinkIndex()))
			scrollToIndex(getActiveLinkIndex());
	});
}
