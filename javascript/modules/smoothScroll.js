import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function smoothScroll() {
	// Initialize a new Lenis instance for smooth scrolling
	window.lenis = new Lenis({
		lerp: 0.2,
	});

	// Synchronize Lenis scrolling with GSAP's ScrollTrigger plugin
	window.lenis.on('scroll', ScrollTrigger.update);

	// Add Lenis's requestAnimationFrame (raf) method to GSAP's ticker
	// This ensures Lenis's smooth scroll animation updates on each GSAP tick
	gsap.ticker.add((time) => {
		window.lenis.raf(time * 1000); // Convert time from seconds to milliseconds
	});

	// Disable lag smoothing in GSAP to prevent any delay in scroll animations
	gsap.ticker.lagSmoothing(0);
}
