// import Swiper JS
import Swiper from 'swiper';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { Autoplay, Pagination } from 'swiper/modules';
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
				delay: 3100,
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
					slidesPerView: 3,
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
	const navSwiperTarget = document.querySelector('[data-nav-slider-target="nav"]');
	if (!navSwiperTarget) return;

	// 1. Init custom swiper
	const navSwiper = new NavigationSwiper(navSwiperTarget, 5);
	window.activeNavSwiperInstance = navSwiper;

	if (navSwiper.swiperSlides.length) {
		gsap.from(navSwiper.swiperSlides, {
			opacity: 0,
			stagger: 0.1,
			ease: 'linear',
		});
	}

	// 2. Mark current link
	function setCurrentLink() {
		// Get current URL without hash
		const currentUrlWithoutHash = window.location.origin + window.location.pathname + window.location.search;

		if (!navSwiper.swiperSlides.length) {
			gsap.to(navSwiper.target, {
				x: '-2rem',
				duration: 0.3,
				ease: 'smooth',
			});
		} else {
			gsap.to(navSwiper.target, {
				x: 0,
				ease: 'smooth',
			});
		}

		navSwiper.swiperSlides.forEach((slide, index) => {
			// Get slide URL without hash
			const slideUrl = new URL(slide.href);
			const slideUrlWithoutHash = slideUrl.origin + slideUrl.pathname + slideUrl.search;

			if (slideUrlWithoutHash === currentUrlWithoutHash) {
				slide.classList.add('is-current');

				// If current not visible, scroll it into view.
				// Using setTimeout because need to wait for initial adjustWidth to at least partially complete
				setTimeout(() => {
					if (!navSwiper.isSlideVisible(index)) {
						navSwiper.scrollToSlide(index);
					} else {
						navSwiper.adjustWidth();
					}
				}, 300);
			} else {
				slide.classList.remove('is-current');
			}
		});
	}
	setCurrentLink();

	// Remove old event listener before adding a new one
	if (window.activeNavPageSwitchHandler) {
		document.removeEventListener('pageSwitched', window.activeNavPageSwitchHandler);
	}

	// Store the handler reference on window
	window.activeNavPageSwitchHandler = (e) => {
		if (e.detail.parentPageChanged) return;
		setCurrentLink();
	};

	document.addEventListener('pageSwitched', window.activeNavPageSwitchHandler);
}

export function anchorSwiper() {
	const navSwiperTarget = document.querySelector('[data-nav-slider-target="anchor"]');
	const sectionsWrap = document.querySelector('[data-hero-scroll="content-wrap"]');

	if (!navSwiperTarget || !sectionsWrap) return;

	const anchorSections = sectionsWrap.querySelectorAll('section');

	function setActiveLink(activeSectionId) {
		navSwiper.swiperSlides.forEach((slide, index) => {
			if (activeSectionId === slide.hash.slice(1)) {
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

	// 1. Init custom swiper
	const navSwiper = new NavigationSwiper(navSwiperTarget, 5);

	// 2. Set active link
	anchorSections.forEach((section) => {
		ScrollTrigger.create({
			trigger: section,
			start: 'top center',
			end: 'bottom center',
			onEnter: () => {
				setActiveLink(section.id);
			},
			onEnterBack: () => {
				setActiveLink(section.id);
			},
		});
	});

	// 3. Show/Hide anchor wrap
	let displayTl = gsap.timeline({
		scrollTrigger: {
			trigger: sectionsWrap,
			start: 'top top',
			endTrigger: 'footer',
			end: 'top bottom',
			toggleActions: 'play reverse play none',
		},
	});

	displayTl.to(navSwiperTarget, {
		autoAlpha: 1,
		y: 0,
		duration: 0.1,
	});
}
