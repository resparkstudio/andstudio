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
} from './modules/animations';
import { strategy6Swiper, navigationSwiper } from './modules/swipers';

// These functions will be called again on pageLoaded event (scroll transition)
function initPageLoaded(
	container = document.querySelector('[data-scroll-transition="content"]')
) {
	heroScrollAnimation(container);
	strategy6Swiper(container);
	footerTextFit(container);
	footerPin(container);
}

// These functions will be called when previous page is removed (scroll transition)
function initPageSwitched() {
	setActiveNavLink();
}

document.addEventListener('DOMContentLoaded', () => {
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
	navigationSwiper();
});

document.addEventListener('pageLoaded', (e) => {
	// Pass new page's container
	initPageLoaded(e.detail.container);
});

document.addEventListener('pageSwitched', () => {
	initPageSwitched();
});
