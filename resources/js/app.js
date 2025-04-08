import './bootstrap';
import Alpine from 'alpinejs';

window.deferLoadingAlpine = function (callback) {
    window.addEventListener('alpine:initialized', callback);
};

window.Alpine = Alpine;
Alpine.start();

// My file CRUD
import './crud';