// import Swiper JS
import Swiper from 'swiper';
import gsap from 'gsap';
import { Autoplay, Controller, EffectFade, Navigation, Pagination } from 'swiper/modules';
import { NavigationSwiper } from './NavigationSwiper';

export function block6Swiper(container) {
	const swiperTargets = container.querySelectorAll('[data-swiper="block-6"]');

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

export function block13Swiper(container) {
	const swiperTargets = container.querySelectorAll('[data-swiper="block-13"]');

	if (!swiperTargets.length) return;

	swiperTargets.forEach((target) => {
		const swiper = new Swiper(target, {
			slidesPerView: 1.05,
			spaceBetween: 12,
		});
	});
}

export function block17Swiper(container) {
	const swiperTargets = container.querySelectorAll('[data-swiper="block-17"]');

	if (!swiperTargets.length) return;

	swiperTargets.forEach((target) => {
		const pagination = target.querySelector('[data-swiper-pagination]');

		const swiper = new Swiper(target, {
			modules: [Autoplay, Pagination],
			slidesPerView: 1.1,
			centeredSlides: true,
			loop: true,
			autoplay: {
				delay: 3000,
			},
			spaceBetween: 12,
			speed: 800,
			pagination: {
				type: 'bullets',
				el: pagination,
				clickable: true,
				renderBullet: function (index, className) {
					return `<span class="pagination-bullet ${className}">
		<span class="pagination-bg">0${index + 1}</span>
		<span class="pagination-fg">0${index + 1}</span>
	</span>`;
				},
			},
			breakpoints: {
				768: {
					slidesPerView: 'auto',
				},
			},
		});

		setTimeout(() => {
			swiper.update();
		}, 1000);
	});
}

export function block23Swiper(container) {
	const swiperTargets = container.querySelectorAll('[data-swiper="block-23"]');

	if (!swiperTargets.length) return;

	swiperTargets.forEach((target) => {
		const swiper = new Swiper(target, {
			slidesPerView: 1.05,
			spaceBetween: 12,
		});
	});
}

export function block26Swiper(container) {
	const swiperTargets = container.querySelectorAll('[data-swiper="block-26"]');

	if (!swiperTargets.length) return;

	swiperTargets.forEach((target) => {
		const swiper = new Swiper(target, {
			slidesPerView: 1.05,
			spaceBetween: 12,
		});
	});
}

export function navigationSwiper() {
	const navSwiperTarget = document.querySelector('[data-nav-slider="target"]');
	if (navSwiperTarget) {
		// 1. Init custom swiper
		const navSwiper = new NavigationSwiper(navSwiperTarget);

		// 2. Mark current link
		function setCurrentLink() {
			navSwiper.swiperSlides.forEach((slide, index) => {
				if (slide.href === window.location.href) {
					slide.classList.add('is-current');

					// If current not visible, scroll it into view
					if (!navSwiper.isSlideVisible(index)) {
						navSwiper.scrollToSlide(index);
					} else {
						navSwiper.adjustWidth();
					}
				} else {
					slide.classList.remove('is-current');
				}
			});
		}
		setCurrentLink();

		document.addEventListener('pageSwitched', () => {
			setCurrentLink();
		});
	}
}
