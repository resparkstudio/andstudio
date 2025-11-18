import gsap from 'gsap';

export class NavigationSwiper {
	constructor(target, visibleCount = 5) {
		this.target = target;
		this.activeIndex = 0;
		this.visibleCount = visibleCount;
		this.swiperContainer = this.target.querySelector('[data-nav-slider="container"]');
		this.swiperWrap = this.swiperContainer.querySelector('[data-nav-slider="wrap"]');
		this.swiperSlides = this.swiperContainer.querySelectorAll('[data-nav-slider="item"]');
		this.prevButton = this.swiperContainer.querySelector('.swiper-button-prev');
		this.nextButton = this.swiperContainer.querySelector('.swiper-button-next');

		// Target values for animations (used to calculate nav state before animations complete)
		this.targetScrollPosition = null;
		this.targetFinalWidth = null;

		this.init();
	}

	init() {
		this.initNavButtons();
		this.adjustWidth();

		window.addEventListener('resize', () => {
			this.scrollToSlide(this.activeIndex);

			if (this.isOverflowing()) {
				this.showNavButtons();
			} else if (!this.isOverflowing() && this.swiperSlides.length <= this.visibleCount) {
				this.hideNavButtons();
			}
		});

		// Disable touchpad scrolling
		this.swiperWrap.addEventListener(
			'wheel',
			(e) => {
				e.preventDefault();
			},
			{ passive: false }
		);
	}

	initNavButtons() {
		// Show/Hide nav buttons
		if (this.swiperSlides.length <= this.visibleCount && !this.isOverflowing()) {
			this.hideNavButtons();
		} else {
			this.showNavButtons();
		}

		// Add event listeners
		this.prevButton.addEventListener('click', () => {
			if (this.activeIndex > 0) {
				this.activeIndex--;
				this.changeSlide();
			}
		});

		// Only works if last slide not visible yet
		this.nextButton.addEventListener('click', () => {
			if (!this.isScrollAtEnd()) {
				this.activeIndex++;
				this.changeSlide();
			}
		});
	}

	hideNavButtons() {
		this.prevButton.classList.add('hidden');
		this.nextButton.classList.add('hidden');
		this.prevButton.disabled = true;
		this.nextButton.disabled = true;
	}

	showNavButtons() {
		this.prevButton.classList.remove('hidden');
		this.nextButton.classList.remove('hidden');
		this.prevButton.disabled = false;
		this.nextButton.disabled = false;
	}

	changeSlide() {
		const animationDuration = 0.6;

		// Calculate and store target scroll position
		this.targetScrollPosition = 0;
		for (let i = 0; i < this.activeIndex; i++) {
			this.targetScrollPosition += this.swiperSlides[i].offsetWidth + 32; // Add slide width + gap
		}

		// Go to scroll position
		gsap.to(this.swiperWrap, {
			scrollLeft: this.targetScrollPosition,
			duration: animationDuration,
			ease: 'custom',
		});

		// At the same time adjust width
		this.adjustWidth(false);
	}

	adjustWidth(instant = false) {
		const animationDuration = instant ? 0 : 0.6;

		// Calculate width of visible slides
		let swiperWidth = 0;
		for (let i = this.activeIndex; i < this.activeIndex + this.visibleCount && i < this.swiperSlides.length; i++) {
			swiperWidth += this.swiperSlides[i].offsetWidth;
		}

		// Add spacing between slides (additionally adding 2px to width for buffer)
		swiperWidth += (Math.min(this.visibleCount, this.swiperSlides.length) - 1) * 32 + 2;

		const maxSwiperWidth = this.calculateMaxWidth();

		// Store target width
		this.targetFinalWidth = Math.min(swiperWidth, maxSwiperWidth);

		// Update nav state before the width and scroll animations end since we have final values
		this.handleNavState();

		gsap.to(this.swiperWrap, {
			width: this.targetFinalWidth,
			duration: animationDuration,
			ease: 'custom',
		});
	}

	calculateMaxWidth() {
		const maxTargetWidth = this.target.offsetWidth;

		const containerWidth = this.swiperContainer.offsetWidth;
		const swiperPadding = containerWidth - this.swiperWrap.offsetWidth;

		return maxTargetWidth - swiperPadding;
	}

	scrollToSlide(index) {
		// Check if slide is before visible area
		const slide = this.swiperSlides[index];

		const containerRect = this.swiperWrap.getBoundingClientRect();
		const slideRect = slide.getBoundingClientRect();
		const isBeforeVisibleArea = slideRect.left < containerRect.left;

		if (isBeforeVisibleArea) {
			// Slide is before visible area - make it the FIRST visible item
			this.activeIndex = index;
		} else {
			// Slide is after visible area - make it the LAST visible item
			const maxSwiperWidth = this.calculateMaxWidth();
			let slideIndex = index;
			let accumulatedWidth = 0;
			let slidesCount = 0;

			// Count backwards, respecting both visibleCount and maxSwiperWidth
			while (slideIndex >= 0 && slidesCount < this.visibleCount) {
				const slideWidth = this.swiperSlides[slideIndex].offsetWidth;
				const gap = slidesCount > 0 ? 32 : 0;

				if (accumulatedWidth + slideWidth + gap > maxSwiperWidth) {
					break;
				}

				accumulatedWidth += slideWidth + gap;
				slidesCount++;
				slideIndex--;
			}

			this.activeIndex = Math.max(0, slideIndex + 1);
		}

		this.changeSlide();
	}

	isSlideVisible(index) {
		const slide = this.swiperSlides[index];
		const containerRect = this.swiperWrap.getBoundingClientRect();
		const slideRect = slide.getBoundingClientRect();

		const isVisibleOnLeft = slideRect.left >= containerRect.left - 2;
		const isVisibleOnRight = slideRect.right <= containerRect.right + 2;

		return isVisibleOnLeft && isVisibleOnRight;
	}

	isOverflowing() {
		return this.swiperWrap.scrollWidth > this.calculateMaxWidth();
	}

	isScrollAtEnd() {
		// Use target values if set (during animation), otherwise use actual DOM values
		const scrollLeft = this.targetScrollPosition ?? this.swiperWrap.scrollLeft;
		const clientWidth = this.targetFinalWidth ?? this.swiperWrap.clientWidth;

		const scrollWidth = this.swiperWrap.scrollWidth;
		const tolerance = 2;

		return scrollLeft + clientWidth >= scrollWidth - tolerance;
	}

	handleNavState() {
		// Handle prev button
		if (this.activeIndex === 0) {
			this.prevButton.classList.add('swiper-button-disabled');
		} else {
			this.prevButton.classList.remove('swiper-button-disabled');
		}

		if (this.isScrollAtEnd()) {
			this.nextButton.classList.add('swiper-button-disabled');
		} else {
			this.nextButton.classList.remove('swiper-button-disabled');
		}
	}
}
