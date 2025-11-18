import gsap from 'gsap';
import { CustomEase } from 'gsap/CustomEase';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import textFit from 'textfit';

gsap.registerPlugin(CustomEase);
gsap.registerPlugin(ScrollTrigger);
CustomEase.create('custom', 'M0,0 C0.204,0 0.192,0.726 0.318,0.852 0.45,0.984 0.504,1 1,1');
CustomEase.create('smooth', '0.5, 0, 0, 1');

export function introAnimation() {
	const images = document.querySelectorAll('[data-intro-image]');

	if (!images.length) return;

	const imagesArray = Array.from(images);
	const introContent = document.querySelector('[data-intro-content]');

	// create
	let mm = gsap.matchMedia();

	// Desktop animation
	mm.add('(min-width: 768px)', () => {
		let tl = gsap.timeline();

		tl.from(imagesArray[2], {
			height: '100%',
			width: '100%',
			top: 0,
			left: 0,
			duration: 3,
			ease: 'power2.inOut',
		})
			.from(
				imagesArray.slice(0, 2).concat(imagesArray.slice(3, 8)),
				{
					width: '60%',
					duration: 3,
					ease: 'power2.inOut',
				},
				'<'
			)
			.from(
				introContent,
				{
					opacity: 0,
					scale: 0.5,
					duration: 1.5,
					ease: 'back.out(1.7)',
				},
				'<1.5'
			);

		return () => {
			// custom cleanup code here (runs when it STOPS matching)
		};
	});

	mm.add('(max-width: 767px)', () => {
		let tl = gsap.timeline();

		tl.from(imagesArray[2], {
			scale: 1.5,
			duration: 1.5,
			ease: 'power3.inOut',
		}).from(
			introContent,
			{
				opacity: 0,
				scale: 0.5,
				duration: 0.8,
				ease: 'back.out(1.4)',
			},
			'<1.2'
		);

		return () => {
			// custom cleanup code here (runs when it STOPS matching)
		};
	});
}

// Mouse follow effect with GSAP
export function floatingImagesEffect() {
	// Get your image containers
	const plane1 = document.querySelectorAll('[data-floating-plane="1"]'); // Fastest layer
	const plane2 = document.querySelectorAll('[data-floating-plane="2"]'); // Medium layer

	// Check if elements exist
	if (!plane1 && !plane2) {
		console.warn('Mouse follow elements not found');
		return;
	}

	// Animation variables
	let requestAnimationFrameId = null;
	let xForce = 0;
	let yForce = 0;
	const easing = 0.08;
	const speed = 0.01;

	// Linear interpolation function
	const lerp = (start, target, amount) => start * (1 - amount) + target * amount;

	// Mouse move handler
	const manageMouseMove = (e) => {
		const { movementX, movementY } = e;
		xForce += movementX * speed;
		yForce += movementY * speed;

		// Start animation if not already running
		if (requestAnimationFrameId == null) {
			requestAnimationFrameId = requestAnimationFrame(animate);
		}
	};

	// Animation loop
	const animate = () => {
		// Ease the forces towards 0
		xForce = lerp(xForce, 0, easing);
		yForce = lerp(yForce, 0, easing);

		// Apply movement to each plane with different intensities
		if (plane1.length) {
			gsap.set(plane1, { x: `+=${xForce}`, y: `+=${yForce}` });
		}
		if (plane2.length) {
			gsap.set(plane2, {
				x: `+=${xForce * 0.5}`,
				y: `+=${yForce * 0.5}`,
			});
		}

		// Stop very small movements to prevent infinite animation
		if (Math.abs(xForce) < 0.01) xForce = 0;
		if (Math.abs(yForce) < 0.01) yForce = 0;

		// Continue animation if there's still movement
		if (xForce != 0 || yForce != 0) {
			requestAnimationFrame(animate);
		} else {
			cancelAnimationFrame(requestAnimationFrameId);
			requestAnimationFrameId = null;
		}
	};

	// Add event listener
	document.body.addEventListener('mousemove', manageMouseMove);
}

export function heroRevealAnimation() {
	const header = document.querySelector('[data-hero-reveal="header"]');

	if (!header) return;

	const heroImg = document.querySelector('[data-hero-reveal="image"]');
	const heroBanner = document.querySelector('[data-hero-reveal="banner"]');

	let tl = gsap.timeline({
		onComplete: () => {
			gsap.set(header, { clearProps: 'transform' }); // Clear transform after animation
		},
	});

	if (heroImg) {
		tl.from(heroImg, {
			scale: 1.2,
			duration: 1.4,
			ease: 'smooth',
		});
	}
	tl.from(
		header,
		{
			y: '-100%',
			duration: 1,
			ease: 'smooth',
		},
		'<'
	);
	if (heroBanner) {
		tl.from(
			heroBanner,
			{
				yPercent: 130,
				scale: 1.2,
				duration: 1,
				ease: 'smooth',
			},
			'<'
		);
	}
}

export function heroScrollAnimation(container) {
	const heroSection = container.querySelector('[data-hero-scroll="hero-section"]');

	if (!heroSection) return;

	const heroImg = container.querySelector('[data-hero-reveal="image"]');
	const contentWrap = container.querySelector('[data-hero-scroll="content-wrap"]');

	let mm = gsap.matchMedia();

	// add a media query. When it matches, the associated function will run
	mm.add('(min-width: 768px)', () => {
		let imgTl = gsap.timeline({
			scrollTrigger: {
				trigger: heroSection,
				start: 'top top',
				end: 'bottom top',
				scrub: true,
			},
		});

		imgTl.to(heroImg, {
			yPercent: -30,
			ease: 'linear',
		});

		let sectionTl = gsap.timeline({
			scrollTrigger: {
				trigger: heroSection,
				start: 'top top',
				end: '+=600',
				scrub: true,
				onLeave: () => {
					// Clear transform AFTER animation completes
					gsap.set(contentWrap, { clearProps: 'transform' });
					setTimeout(() => {
						ScrollTrigger.refresh();
					}, 100);
				},
			},
		});

		sectionTl.from(contentWrap, {
			scale: 0.92,
			ease: 'linear',
		});

		return () => {};
	});
}

export function footerTextFit(container) {
	const targets = container.querySelectorAll('[data-text-fit="target"]');

	if (!targets.length) return;

	targets.forEach((target) => {
		textFit(target, {
			maxFontSize: 9999,
			widthOnly: true,
		});
	});

	let resizeTimer;
	window.addEventListener('resize', () => {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(() => {
			footerTextFit(container);
		}, 250);
	});
}

export function footerPin(container) {
	const footer = container.querySelector('footer');

	if (!footer) return;

	const parallaxFooterEl = footer.querySelector('[data-scroll-transition="parallax-footer"]');

	let tl = gsap.timeline({
		scrollTrigger: {
			trigger: footer,
			pin: footer,
			scrub: true,
			start: 'top top',
			end: 'bottom top',
			pinSpacing: false,
		},
	});

	tl.to(parallaxFooterEl, {
		yPercent: -40,
		ease: 'linear',
	});
}

export function horizontalScrollGallery(container) {
	const scrollTracks = container.querySelectorAll('[data-scroll-gallery="track"]');

	if (!scrollTracks) return;

	scrollTracks.forEach((track) => {
		const galleryWrap = track.querySelector('[data-scroll-gallery="wrap"]');

		let mm = gsap.matchMedia();

		mm.add('(min-width: 768px)', () => {
			const scrollAmount = galleryWrap.scrollWidth - track.offsetWidth;

			track.style.height = `${window.innerHeight + scrollAmount}px`;

			let tl = gsap.timeline({
				scrollTrigger: {
					trigger: track,
					start: 'top top',
					end: 'bottom bottom',
					scrub: true,
				},
			});

			tl.to(galleryWrap, {
				x: -scrollAmount,
			});
			return () => {};
		});
	});
}
