/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

import { initAlpineJS } from './modules/alpine';
import { pageScrollTransition } from './modules/pageScrollTransition';
import {
	ajaxPagePasswordForm,
	ajaxPageEntryCta,
} from './modules/ajaxPageIntro';
import {
	introAnimation,
	floatingImagesEffect,
	menuAnimation,
	subpageMenuAnimation,
	activeMenuItemDisplay,
	heroRevealAnimation,
	heroScrollAnimation,
	footerTextFit,
	footerPin,
	setActiveNavLink,
	horizontalScrollGallery,
} from './modules/animations';
import {
	block6Swiper,
	block13Swiper,
	block17Swiper,
	block23Swiper,
	block26Swiper,
} from './modules/swipers';
import { overflowNavigation } from './modules/overflowNavigation';

// These functions will be called again on pageLoaded event (scroll transition)
function initPageLoaded(
	container = document.querySelector('[data-scroll-transition="content"]')
) {
	// Intro page for example
	if (!container) return;

	heroScrollAnimation(container);
	block6Swiper(container);
	block13Swiper(container);
	block17Swiper(container);
	block23Swiper(container);
	block26Swiper(container);
	footerTextFit(container);
	footerPin(container);
	horizontalScrollGallery(container);
}

// These functions will be called when previous page is removed (scroll transition)
function initPageSwitched() {
	setActiveNavLink();
}

document.addEventListener('DOMContentLoaded', () => {
	initAlpineJS();
	initPageLoaded();
	initPageSwitched();
	pageScrollTransition();
	ajaxPagePasswordForm();
	ajaxPageEntryCta();
	introAnimation();
	floatingImagesEffect();
	menuAnimation();
	subpageMenuAnimation();
	activeMenuItemDisplay();
	heroRevealAnimation();
	overflowNavigation();
});

document.addEventListener('pageLoaded', (e) => {
	// Pass new page's container
	initPageLoaded(e.detail.container);
});

document.addEventListener('pageSwitched', () => {
	initPageSwitched();
});
