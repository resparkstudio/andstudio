import gsap from 'gsap';

export function menuAnimation() {
	const modal = document.querySelector('[data-menu-animation="modal"]');
	if (!modal) return;

	const overlay = modal.querySelector('[data-menu-animation="overlay"]');
	const openButtons = document.querySelectorAll('[data-menu-animation="open-btn"]');
	const closeButtons = document.querySelectorAll('[data-menu-animation="close-btn"]');
	const background = modal.querySelector('[data-menu-animation="background"]');
	const navLinks = modal.querySelectorAll('[data-menu-animation="nav-link"]');
	const privacyWrap = modal.querySelector('[data-menu-animation="privacy-wrap"]');

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
			.from(privacyWrap, { opacity: 0, duration: 0.8, ease: 'power1.out' }, '<0.3')
			.from(closeButtons, { opacity: 0, scale: 0.5, duration: 0.4, ease: 'power2.out' }, '<');

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
			.to(navLinks, { opacity: 0, duration: 0.2, ease: 'power1.out' }, '<')
			.to(privacyWrap, { opacity: 0, duration: 0.2, ease: 'power1.out' }, '<')
			.to(closeButtons, { opacity: 0, scale: 0.5, duration: 0.2, ease: 'power2.out' }, '<')
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
			.from(closeButtons, { opacity: 0, scale: 0.5, duration: 0.4, ease: 'power2.out' }, '<0.2')
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
			.from(privacyWrap, { opacity: 0, duration: 0.8, ease: 'power1.out' }, '<0.3');

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
			.to(navLinks, { opacity: 0, duration: 0.2, ease: 'power1.out' }, '<')
			.to(privacyWrap, { opacity: 0, duration: 0.2, ease: 'power1.out' }, '<')
			.to(closeButtons, { opacity: 0, scale: 0.5, duration: 0.2, ease: 'power2.out' }, '<')
			.set(modal, { display: 'none' });
	});

	function openMenu() {
		if (closeTl.isActive()) closeTl.kill();
		openTl.restart();

		// Dispatch menuOpen event so submenu animation can run if active menu item
		const menuOpenEvent = new CustomEvent('menuOpen');
		document.dispatchEvent(menuOpenEvent);
	}

	function closeMenu() {
		if (openTl.isActive()) openTl.kill();
		closeTl.restart();

		// Dispatch custom event when menu starts closing
		const menuCloseEvent = new CustomEvent('menuClose');
		document.dispatchEvent(menuCloseEvent);

		// Dispatch custom event when menu is completely closed
		closeTl.eventCallback('onComplete', () => {
			const menuClosedEvent = new CustomEvent('menuClosed');
			document.dispatchEvent(menuClosedEvent);
		});
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
	const subpageContainers = document.querySelectorAll('[data-submenu-animation="container"]');
	const subpageTriggers = document.querySelectorAll('[data-submenu-animation="trigger"]');

	if (!subpageContainers.length || !subpageTriggers.length) return;

	const navLinks = document.querySelectorAll('[data-menu-animation="nav-link"]');
	const desktopBackground = document.querySelector('[data-submenu-animation="desktop-background"]');

	let openSubpageId = null; // Modal that should be closed when menu closes
	let modalAnimationFunctions = {}; // Open and Close animation functions for each subpage modal
	let initiallyActiveLink = null; // Current page link
	let submenuOpen = false;

	// Find the best matching link for a given URL
	function findActiveLink(url = window.location.href) {
		let bestMatch = null;
		let longestMatchLength = 0;

		navLinks.forEach((link) => {
			const linkHref = link.href;
			if (url.startsWith(linkHref) && linkHref.length > longestMatchLength) {
				bestMatch = link;
				longestMatchLength = linkHref.length;
			}
		});

		return bestMatch;
	}

	// Set the active link based on URL
	function setActiveLink(url = window.location.href) {
		const activeLink = findActiveLink(url);

		navLinks.forEach((link) => {
			link.classList.remove('is-current');
		});

		if (activeLink) {
			activeLink.classList.add('is-current');
			initiallyActiveLink = activeLink;
		}
	}

	// Adds is-current class to clicked link and removes from previously active link
	function changeActiveLink(clickedLink) {
		navLinks.forEach((link) => {
			if (link !== clickedLink) {
				link.classList.remove('is-current');
			} else {
				link.classList.add('is-current');
			}
		});
	}

	// Returns is-current class to initially active link
	function resetActiveLink() {
		navLinks.forEach((link) => {
			if (link !== initiallyActiveLink) {
				link.classList.remove('is-current');
			} else {
				link.classList.add('is-current');
			}
		});
	}

	// Set initially active nav link on page load
	setActiveLink();

	subpageContainers.forEach((container) => {
		const triggerId = container.dataset.modalParentId;
		const modal = container.querySelector('[data-submenu-animation="modal"]');
		const overlay = container.querySelector('[data-submenu-animation="overlay"]');
		const closeBtn = container.querySelector('[data-submenu-animation="close-btn"]');
		const subpageLinks = container.querySelectorAll('[data-submenu-animation="link"]');

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

			return () => {
				// Clear animations storage
				modalAnimationFunctions = {};
			};
		});

		// Desktop animation
		mm.add('(min-width: 768px)', () => {
			function showSubmenu() {
				const modalDelay = submenuOpen ? '<' : '<0.6';
				submenuOpen = true;

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
							ease: 'power2.out',
							duration: 0.3,
						},
						modalDelay
					)
					.fromTo(
						subpageLinks,
						{
							clipPath: 'inset(50% 20% 0% 20% round 20px)',
						},
						{
							clipPath: 'inset(0% 0% 0% 0% round 20px)',
							duration: 0.6,
							ease: 'smooth',
						},
						'<'
					);

				masterTl.restart();
			}

			function closeSubmenu() {
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

			return () => {
				// Clear animations storage
				modalAnimationFunctions = {};
			};
		});

		// Mobile close
		overlay.addEventListener('click', () => {
			const { closeSubmenu } = modalAnimationFunctions[triggerId];
			closeSubmenu();
			resetActiveLink();
		});
		closeBtn.addEventListener('click', () => {
			const { closeSubmenu } = modalAnimationFunctions[triggerId];
			closeSubmenu();
			resetActiveLink();
		});
	});

	subpageTriggers.forEach((trigger) => {
		const modalId = trigger.dataset.modalId;

		trigger.addEventListener('click', (e) => {
			e.preventDefault();
			const { showSubmenu } = modalAnimationFunctions[modalId];
			// Temporary set as active link
			changeActiveLink(trigger);

			// Hide previously visible subpage content
			if (openSubpageId) {
				const { closeSubmenu } = modalAnimationFunctions[openSubpageId];
				closeSubmenu();
			}
			showSubmenu();
			openSubpageId = modalId;
		});
	});

	// Close any open subpage modal when main menu closes
	document.addEventListener('menuClose', () => {
		if (openSubpageId) {
			const { closeSubmenu } = modalAnimationFunctions[openSubpageId];
			closeSubmenu();
			submenuOpen = false;

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

	// Reset is-current link to current page when menu is closed
	document.addEventListener('menuClosed', resetActiveLink);

	// Open submenu of active page when menu is opened
	document.addEventListener('menuOpen', () => {
		// Return if current page does not have a submodal
		if (!initiallyActiveLink) return;
		const activeModalId = initiallyActiveLink.dataset.modalId;
		if (!activeModalId) return;

		const { showSubmenu } = modalAnimationFunctions[activeModalId];
		setTimeout(() => {
			showSubmenu();
			openSubpageId = activeModalId;
		}, 600);
	});

	// Change active nav link on page change
	document.addEventListener('pageSwitched', (e) => {
		const newUrl = e.detail.newUrl || window.location.href;
		setActiveLink(newUrl);
	});
}
