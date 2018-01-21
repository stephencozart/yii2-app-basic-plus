require('./classlist.shim');

require('es6-promise').polyfill();

window.__forceSmoothScrollPolyfill__ = true;

require('smoothscroll-polyfill').polyfill();

try {

    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {

    window.axios.defaults.headers.common['X-CSRF-Token'] = token.content;

} else {

    console.error('CSRF token not found. Make sure that Html::csrfMetaTags() is being used in the <head> of your layout');

}