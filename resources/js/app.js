import './bootstrap';

import '@fortawesome/fontawesome-free/css/all.min.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

document.addEventListener('DOMContentLoaded', () => {
	const el = document.querySelector('#expires_at');
	if (!el) return;

	flatpickr(el, {
		enableTime: true,
		dateFormat: "Y-m-d\TH:i",
		time_24hr: false,
		allowInput: true,
	});
});
