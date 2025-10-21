// import Swiper JS
import Swiper from 'swiper';
import gsap from 'gsap';
import {
	Autoplay,
	Controller,
	EffectFade,
	Navigation,
	Pagination,
} from 'swiper/modules';

/* Swiper utility functions */
function swiperAdjustWidth(
	swiper,
	visibleCount,
	swiperContainer,
	instant = false
) {
	const slides = swiper.slides;
	const activeIndex = swiper.activeIndex;
	const animationDuration = instant ? 0 : 0.6;
	const swiperWrap = swiperContainer.querySelector(
		'[data-nav-slider="wrap"]'
	);

	// Calculate width of visible slides
	let swiperWidth = 0;
	for (
		let i = activeIndex;
		i < activeIndex + visibleCount && i < slides.length;
		i++
	) {
		swiperWidth += slides[i].offsetWidth;
	}

	// Add spacing between slides
	swiperWidth += (visibleCount - 1) * 32;

	const maxSwiperWidth = swiperCalculateMaxWidth(
		swiperContainer,
		swiperWrap,
		swiper
	);

	const finalWidth = Math.min(swiperWidth, maxSwiperWidth);

	gsap.to(swiper.el, {
		width: finalWidth,
		duration: animationDuration,
		ease: 'custom',
		overwrite: true,
	});

	swiper.update();
}

function swiperCalculateMaxWidth(swiperContainer, swiperWrap, swiper) {
	const containerWidth = swiperContainer.offsetWidth;
	const swiperPadding = swiperWrap.offsetWidth - swiper.el.offsetWidth;

	return containerWidth - swiperPadding;
}

function swiperActiveSlideIndex(swiper, targetEl, activeClass) {
	let activeSlideIndex = null;

	const slides = swiper.slides;

	// Get currently active nav item slide index
	for (let i = 0; i < slides.length; i++) {
		const link = slides[i].querySelector(targetEl);
		if (link && link.classList.contains(activeClass)) {
			activeSlideIndex = i;
		}
	}

	return activeSlideIndex;
}

function swiperIsSlideVisible(swiper, slideIndex) {
	const slide = swiper.slides[slideIndex];

	if (!slide) return false;

	// Get swiper container position
	const swiperRect = swiper.el.getBoundingClientRect();
	// Get slide position
	const slideRect = slide.getBoundingClientRect();

	return (
		slideRect.left >= swiperRect.left && slideRect.right <= swiperRect.right
	);
}

export function strategy6Swiper(container) {
	const swiperTargets = container.querySelectorAll(
		'[data-swiper="strategy-6-block"]'
	);

	if (!swiperTargets.length) return;

	let swiperInstances = [];
	const mobileBreakpoint = 768;

	function initSwipers() {
		swiperTargets.forEach((target) => {
			const swiper = new Swiper(target, {
				slidesPerView: 1.15,
				spaceBetween: 12,
				breakpoints: {
					768: {
						enabled: false, // Disable swiper on desktop
					},
				},
			});

			swiperInstances.push(swiper);
		});
	}
	function destroySwipers() {
		swiperInstances.forEach((swiperInstance) => {
			swiperInstance.destroy(true, true);
			swiperInstances = [];
		});
	}

	function breakpointHandler() {
		if (window.innerWidth > mobileBreakpoint) {
			destroySwipers();
		} else if (window.innerWidth <= mobileBreakpoint) {
			initSwipers();
		}
	}

	// Initialize or not on initial page load
	breakpointHandler();

	window.addEventListener('resize', () => {
		breakpointHandler();
	});
}
