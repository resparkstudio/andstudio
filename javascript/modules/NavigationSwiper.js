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

		this.init();
	}

	init() {
		this.initNavButtons();
		this.adjustWidth(true);

		window.addEventListener('resize', () => {
			this.adjustWidth();
		});
	}

	initNavButtons() {
		this.prevButton.addEventListener('click', () => {
			if (this.activeIndex > 0) {
				this.activeIndex--;
				this.changeSlide();
			}
		});

		// Only works if last slide not visible yet
		this.nextButton.addEventListener('click', () => {
			if (!this.isSlideVisible(this.swiperSlides.length - 1)) {
				this.activeIndex++;
				this.changeSlide();
			}
		});
	}

	changeSlide() {
		this.adjustWidth();

		this.swiperSlides[this.activeIndex].scrollIntoView({
			behavior: 'smooth',
			block: 'nearest',
			inline: 'start', // This aligns to the left
		});
	}

	adjustWidth(instant = false) {
		const animationDuration = instant ? 0 : 0.6;

		// Calculate width of visible slides
		let swiperWidth = 0;
		for (let i = this.activeIndex; i < this.activeIndex + this.visibleCount && i < this.swiperSlides.length; i++) {
			swiperWidth += this.swiperSlides[i].offsetWidth;
		}

		// Add spacing between slides
		swiperWidth += (this.visibleCount - 1) * 32;

		const maxSwiperWidth = this.calculateMaxWidth();

		const finalWidth = Math.min(swiperWidth, maxSwiperWidth);

		gsap.to(this.swiperWrap, {
			width: finalWidth,
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
		if (this.isSlideVisible(index)) {
			return;
		}
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
}
