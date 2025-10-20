import gsap from 'gsap';
import { CustomEase } from 'gsap/CustomEase';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import textFit from 'textfit';

gsap.registerPlugin(CustomEase);
gsap.registerPlugin(ScrollTrigger);
CustomEase.create(
	'custom',
	'M0,0 C0.204,0 0.192,0.726 0.318,0.852 0.45,0.984 0.504,1 1,1'
);
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
	const lerp = (start, target, amount) =>
		start * (1 - amount) + target * amount;

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

export function menuAnimation() {
	const modal = document.querySelector('[data-menu-animation="modal"]');
	if (!modal) return;

	const overlay = modal.querySelector('[data-menu-animation="overlay"]');
	const openButtons = document.querySelectorAll(
		'[data-menu-animation="open-btn"]'
	);
	const closeButtons = document.querySelectorAll(
		'[data-menu-animation="close-btn"]'
	);
	const background = modal.querySelector(
		'[data-menu-animation="background"]'
	);
	const navLinks = modal.querySelectorAll('[data-menu-animation="nav-link"]');
	const privacyWrap = modal.querySelector(
		'[data-menu-animation="privacy-wrap"]'
	);

	// Define timelines once
	let openTl = gsap.timeline({ paused: true });
	let closeTl = gsap.timeline({ paused: true });

	let mm = gsap.matchMedia();

	// Mobile animation
	mm.add('(max-width: 767px)', () => {
		openTl
			.clear()
			.set(modal, { display: 'block', pointerEvents: 'auto' })
			.from(background, {
				width: 0,
				height: 0,
				duration: 1.5,
				ease: 'custom',
			})
			.from(overlay, { opacity: 0, duration: 0.3, ease: 'linear' }, '<')
			.from(
				navLinks,
				{
					opacity: 0,
					y: 16,
					duration: 0.5,
					ease: 'power1.out',
					stagger: { each: 0.05 },
				},
				'<0.4'
			)
			.from(
				privacyWrap,
				{ opacity: 0, duration: 0.8, ease: 'power1.out' },
				'<0.3'
			)
			.from(
				closeButtons,
				{ opacity: 0, scale: 0.5, duration: 0.4, ease: 'power2.out' },
				'<'
			);

		closeTl
			.clear()
			.set(modal, { pointerEvents: 'none' })
			.to(background, {
				width: 0,
				height: 0,
				duration: 1,
				ease: 'custom',
			})
			.to(overlay, { opacity: 0, duration: 0.15, ease: 'linear' }, '<')
			.to(
				navLinks,
				{ opacity: 0, duration: 0.2, ease: 'power1.out' },
				'<'
			)
			.to(
				privacyWrap,
				{ opacity: 0, duration: 0.2, ease: 'power1.out' },
				'<'
			)
			.to(
				closeButtons,
				{ opacity: 0, scale: 0.5, duration: 0.2, ease: 'power2.out' },
				'<'
			)
			.set(modal, { display: 'none' });
	});

	// Desktop animation
	mm.add('(min-width: 768px)', () => {
		openTl
			.clear()
			.set(modal, { display: 'grid', pointerEvents: 'auto' })
			.to(background, {
				width: '100%',
				height: '100%',
				duration: 1.5,
				ease: 'custom',
			})
			.from(overlay, { opacity: 0, duration: 0.3, ease: 'linear' }, '<')
			.from(
				closeButtons,
				{ opacity: 0, scale: 0.5, duration: 0.4, ease: 'power2.out' },
				'<0.2'
			)
			.from(
				navLinks,
				{
					opacity: 0,
					y: 16,
					duration: 0.5,
					ease: 'power1.out',
					stagger: { each: 0.05 },
				},
				'<0.6'
			)
			.from(
				privacyWrap,
				{ opacity: 0, duration: 0.8, ease: 'power1.out' },
				'<0.3'
			);

		closeTl
			.clear()
			.set(modal, { pointerEvents: 'none' })
			.to(background, {
				width: 0,
				height: 0,
				duration: 1,
				ease: 'custom',
			})
			.to(overlay, { opacity: 0, duration: 0.15, ease: 'linear' }, '<')
			.to(
				navLinks,
				{ opacity: 0, duration: 0.2, ease: 'power1.out' },
				'<'
			)
			.to(
				privacyWrap,
				{ opacity: 0, duration: 0.2, ease: 'power1.out' },
				'<'
			)
			.to(
				closeButtons,
				{ opacity: 0, scale: 0.5, duration: 0.2, ease: 'power2.out' },
				'<'
			)
			.set(modal, { display: 'none' });
	});

	function openMenu() {
		if (closeTl.isActive()) closeTl.kill();
		openTl.restart();
	}

	function closeMenu() {
		if (openTl.isActive()) openTl.kill();
		closeTl.restart();
	}

	openButtons.forEach((button) => {
		button.addEventListener('click', openMenu);
	});
	closeButtons.forEach((button) => {
		button.addEventListener('click', closeMenu);
	});
	overlay.addEventListener('click', closeMenu);
}

export function subpageMenuAnimation() {
	const subpageContainers = document.querySelectorAll(
		'[data-submenu-animation="container"]'
	);
	const subpageTriggers = document.querySelectorAll(
		'[data-submenu-animation="trigger"]'
	);

	if (!subpageContainers.length || !subpageTriggers.length) return;

	const modalCloseEvent = new Event('subpageModalClose');
	const desktopBackground = document.querySelector(
		'[data-submenu-animation="desktop-background"]'
	);
	const closeButtons = document.querySelectorAll(
		'[data-menu-animation="close-btn"]'
	);

	let openModalId;
	let modalAnimationFunctions = {};

	subpageContainers.forEach((container) => {
		const triggerId = container.dataset.modalParentId;
		const modal = container.querySelector(
			'[data-submenu-animation="modal"]'
		);
		const overlay = container.querySelector(
			'[data-submenu-animation="overlay"]'
		);
		const closeBtn = container.querySelector(
			'[data-submenu-animation="close-btn"]'
		);

		let mm = gsap.matchMedia();

		// Each modal gets its own master timeline
		let masterTl = gsap.timeline({ paused: true });

		// Mobile animation
		mm.add('(max-width: 767px)', () => {
			function showSubmenu() {
				// Remove previous animations
				masterTl.clear();

				masterTl
					.set(container, {
						pointerEvents: 'auto',
						display: 'flex',
					})
					.to(modal, {
						y: '0%',
						duration: 1,
						ease: 'custom',
					})
					.to(
						overlay,
						{
							opacity: 0.3,
							duration: 0.3,
							ease: 'linear',
						},
						'<'
					);

				masterTl.restart();
			}

			function closeSubmenu() {
				// Dispatch event for activeLink function
				document.dispatchEvent(modalCloseEvent);

				// Remove previous animations
				masterTl.clear();

				masterTl
					.set(container, {
						pointerEvents: 'none',
					})
					.to(modal, {
						y: '100%',
						duration: 0.8,
						ease: 'custom',
					})
					.to(
						overlay,
						{
							opacity: 0,
							duration: 0.15,
							ease: 'linear',
						},
						'<'
					)
					.set(container, {
						display: 'none',
					});

				masterTl.restart();
			}

			modalAnimationFunctions[triggerId] = { showSubmenu, closeSubmenu };

			overlay.addEventListener('click', closeSubmenu);
			closeBtn.addEventListener('click', closeSubmenu);

			return () => {
				// Clear animations storage
				modalAnimationFunctions = {};
			};
		});

		// Desktop animation
		mm.add('(min-width: 768px)', () => {
			function showSubmenu() {
				// Remove previous animations
				masterTl.clear();

				masterTl
					.set(container, {
						pointerEvents: 'auto',
						display: 'flex',
					})
					.to(desktopBackground, {
						width: '100%',
						height: '100%',
						duration: 1.5,
						ease: 'custom',
					})
					.to(
						modal,
						{
							opacity: 1,
							ease: 'linear',
							duration: 0.3,
						},
						'<0.6'
					);

				masterTl.restart();
			}

			function closeSubmenu() {
				// Dispatch event for activeLink function
				document.dispatchEvent(modalCloseEvent);
				// Remove previous animations
				masterTl.clear();

				masterTl
					.set(container, {
						pointerEvents: 'none',
					})
					.to(modal, {
						opacity: 0,
						ease: 'linear',
						duration: 0.1,
					})
					.set(container, {
						display: 'none',
					});

				masterTl.restart();
			}

			modalAnimationFunctions[triggerId] = { showSubmenu, closeSubmenu };

			closeBtn.addEventListener('click', closeSubmenu);

			return () => {
				// Clear animations storage
				modalAnimationFunctions = {};
			};
		});
	});

	subpageTriggers.forEach((trigger) => {
		const modalId = trigger.dataset.modalId;
		const { showSubmenu } = modalAnimationFunctions[modalId];

		trigger.addEventListener('click', () => {
			// Hide previously visible subpage content
			if (openModalId) {
				const { closeSubmenu } = modalAnimationFunctions[openModalId];
				closeSubmenu();
			}
			showSubmenu();
			openModalId = modalId;
		});
	});

	closeButtons.forEach((button) => {
		button.addEventListener('click', () => {
			if (openModalId) {
				const { closeSubmenu } = modalAnimationFunctions[openModalId];
				closeSubmenu();
				gsap.set(desktopBackground, {
					width: desktopBackground.offsetWidth, // Lock current width
					justifySelf: 'end',
				});
				gsap.to(desktopBackground, {
					width: 0,
					height: 0,
					duration: 1,
					ease: 'custom',
					onComplete: () => {
						gsap.set(desktopBackground, {
							justifySelf: 'start',
						});
					},
				});
			}
		});
	});
}

// Kai atidaromas main menu if submenu parent active - showSubmenu()

export function activeMenuItemDisplay() {
	let currentPageLink;
	let activeLink;

	const navLinks = document.querySelectorAll(
		'[data-menu-animation="nav-link"]'
	);

	function toggleActiveLink(link) {
		if (link !== currentPageLink) {
			if (currentPageLink) {
				currentPageLink.classList.remove('is-current');
			}
			link.classList.add('is-current');
			activeLink = link;
		}
	}

	function resetActiveLink() {
		if (currentPageLink) {
			currentPageLink.classList.add('is-current');
		}
		if (activeLink) {
			activeLink.classList.remove('is-current');
			activeLink = null;
		}
	}

	// 1. Get active page link for later
	navLinks.forEach((link) => {
		if (link.classList.contains('is-current')) {
			currentPageLink = link;
		}
	});

	navLinks.forEach((link) => {
		link.addEventListener('click', () => {
			toggleActiveLink(link);
		});
	});

	document.addEventListener('subpageModalClose', resetActiveLink);
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
	const heroSection = container.querySelector(
		'[data-hero-scroll="hero-section"]'
	);

	if (!heroSection) return;

	const heroImg = container.querySelector('[data-hero-reveal="image"]');
	const contentWrap = container.querySelector(
		'[data-hero-scroll="content-wrap"]'
	);

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
		});
	});

	// Call on resize with debounce to avoid performance issues
	let resizeTimer;
	window.addEventListener('resize', () => {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(() => {
			footerTextFit(container);
		}, 100);
	});
}

export function footerPin(container) {
	const footer = container.querySelector('footer');

	if (!footer) return;

	const parallaxFooterEl = footer.querySelector(
		'[data-scroll-transition="parallax-footer"]'
	);

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

export function setActiveNavLink() {
	const navLinks = document.querySelectorAll('[data-nav-link]');

	if (!navLinks.length) return;

	navLinks.forEach((link) => {
		if (link.href === window.location.href) {
			link.classList.add('is-current');
		} else {
			link.classList.remove('is-current');
		}
	});

	const activeNavChanged = new CustomEvent('activeNavChanged');
	document.dispatchEvent(activeNavChanged);
}
