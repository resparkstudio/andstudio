import Alpine from 'alpinejs';
import { collapse } from '@alpinejs/collapse';

export function initAlpineJS() {
	Alpine.plugin(collapse);

	window.Alpine = Alpine;

	Alpine.data('copyColor', () => ({
		copied: false,

		copy(colorCode) {
			// Copy the text inside the text field
			navigator.clipboard.writeText(colorCode);
			this.copied = !this.copied;

			setTimeout(() => {
				this.copied = false;
			}, 2000);
		},
	}));

	Alpine.start();
}
