export function ajaxPagePasswordForm() {
	const form = document.querySelector('[data-page-password-form]');

	if (!form) return;

	const { ajax_url, nonce } = andstudioAjaxData;

	const passwordFieldWrap = form.querySelector(
		'[data-page-password-input-wrap]'
	);
	const passwordField = form.querySelector('[name="page_password"]');
	const pageID = form.querySelector('[name="page_id"]').value;

	function showErrorState() {
		passwordFieldWrap.classList.add('error');
	}

	function hideErrorState() {
		passwordFieldWrap.classList.remove('error');
	}

	async function sendAjaxRequest() {
		const password = passwordField.value;

		const formData = new FormData();

		formData.append('action', 'andstudio_page_password_auth');
		formData.append('password', password);
		formData.append('nonce', nonce);
		formData.append('page_id', pageID);

		try {
			const response = await fetch(ajax_url, {
				method: 'POST',
				body: formData,
			});

			if (!response.ok) {
				throw new Error(`Response status: ${response.status}`);
			}
			const data = await response.json();

			if (data.success) {
				window.location.reload();
			} else {
				// Show error state
				showErrorState();
			}
		} catch (error) {
			console.error(error.message);
		}
	}

	passwordField.addEventListener('input', hideErrorState);

	form.addEventListener('submit', (e) => {
		e.preventDefault();

		sendAjaxRequest();
	});
}

export function ajaxPageEntryCta() {
	const entryBtn = document.querySelector('[data-intro-enter-btn]');

	if (!entryBtn) return;

	const { ajax_url, nonce } = andstudioAjaxData;

	const pageID = entryBtn.dataset.introEnterBtn;

	async function sendAjaxRequest() {
		const formData = new FormData();

		formData.append('action', 'andstudio_unprotected_page_entry_cookie');
		formData.append('page_id', pageID);
		formData.append('nonce', nonce);

		try {
			const response = await fetch(ajax_url, {
				method: 'POST',
				body: formData,
			});

			if (!response.ok) {
				throw new Error(`Response status: ${response.status}`);
			}

			const data = await response.json();

			if (data.success) {
				window.location.reload();
			}
		} catch (error) {
			console.error(error.message);
		}
	}

	entryBtn.addEventListener('click', sendAjaxRequest);
}
