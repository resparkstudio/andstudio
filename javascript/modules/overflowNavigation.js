/**
 * Used for desktop top nav and anchor nav
 */
import gsap from 'gsap';

export function overflowNavigation() {
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

		function adjustNavWidth(instant = false) {
			// Max width = container width - wrap padding width
			const maxWidth =
				target.offsetWidth -
				(navContainer.offsetWidth - navWrap.offsetWidth);

			let navItemsWidth = 0;
			const startIndex = Math.min(
				getFirstVisibleIndex(),
				navLinks.length - visibleCount
			);
			const endIndex = Math.min(
				startIndex + visibleCount,
				navLinks.length - 1
			);

			console.log(`startIndex: ${startIndex}`);
			console.log(`endIndex: ${endIndex}`);
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
			targetLink.scrollIntoView({
				behavior: behavior,
				block: 'nearest',
				inline: inline,
			});

			// Adjust nav width to fit items
			adjustNavWidth();
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

		function scrollToActiveLink(behavior = 'smooth') {
			const activeLink =
				navWrap.querySelector('.is-current')?.parentElement;
			if (!activeLink) {
				currentStartIndex = 0;
				adjustNavWidth(true);
				return;
			}

			const activeNavIndex = Array.from(navLinks).indexOf(activeLink);
			const isVisible = isNavLinkVisible(activeNavIndex); // Fixed: was activeIndex

			if (isVisible) {
				currentStartIndex = 0;
				adjustNavWidth(true);
			} else {
				scrollToIndex(activeNavIndex, behavior, 'end');
				// Sync currentStartIndex with what's actually visible after scroll
				currentStartIndex = getFirstVisibleIndex();
				adjustNavWidth(true);
			}
		}

		nextButton.addEventListener('click', () => {
			// Check if last visible is not last nav link
			const lastVisibleIndex = getLastVisibleIndex();
			if (lastVisibleIndex < navLinks.length - 1) {
				scrollToIndex(lastVisibleIndex + 1, 'smooth', 'end');
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

		// Initial setup
		adjustNavWidth(true);
		scrollToActiveLink('instant');
	});
}
