import Vue from 'vue';
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // Vue js
    window.Vue = Vue;
    // jQuery
    window.$ = window.jQuery = Vue.prototype.$jquery = require('jquery');
    // Axios
    const axios = require('axios').default;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['Accept'] = 'application/json';
    axios.defaults.headers.common['Content-Type'] = 'application/json';
    // Register the CSRF Token
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = null;
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    window.axios = Vue.prototype.$http = axios;
    // Moment
    window.moment = Vue.prototype.$moment = require('moment');
    // Numeral
    window.numeral = Vue.prototype.$numeral = require('numeral');
    // summernote
    require("../../public/plugins/summernote/dist/summernote-lite");
} catch (error) {
    console.error(error);
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
