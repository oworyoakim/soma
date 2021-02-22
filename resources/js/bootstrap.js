/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
// Vue js
import Vue from 'vue';

window.Vue = Vue;
try {
    // jQuery
    window.$ = window.jQuery = require('admin-lte/plugins/jquery/jquery.slim.min');
    // Bootstrap 4+
    require('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min');
    // SweetAlert
    window.Swal = window.SweetAlert = require("admin-lte/plugins/sweetalert2/sweetalert2.min");
    // Toastr
    window.toastr = window.Toastr = require("admin-lte/plugins/toastr/toastr.min");
    // Moment
    window.moment = Vue.prototype.$moment = require('moment');
    // Numeral
    window.numeral = Vue.prototype.$numeral = require('numeral');
    // DateRangePicker
    window.DateRangePicker = Vue.prototype.$DateRangePicker = require('admin-lte/plugins/daterangepicker/daterangepicker');
    // Theme
    require('admin-lte/dist/js/adminlte.min');
} catch (error) {
    console.error(error);
}


Vue.mixin({
    methods: {
        stringLimit(str, length = 20) {
            if (!str) {
                return '';
            }
            if (typeof str !== 'string') {
                str = String(str);
            }

            if (str.length > length) {
                return str.substring(0, length) + " ...";
            }
            return str;
        },
        displayErrorMessage(message) {

        },

        /**
         * Debounce actions that may be costly to repeat
         * @param fn {function}
         * @param delay {number} in milliseconds
         * @returns {function(...[*]): void}
         */
        debounce(fn, delay) {
            let timeoutId = null;
            return function (...args) {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                    return;
                }
                timeoutId = setTimeout(() => {
                    return fn(...args);
                }, delay);
            }
        }
    }
});

Vue.prototype.$isEqual = function (value, other) {

    // Get the value type
    var type = Object.prototype.toString.call(value);

    // If the two objects are not the same type, return false
    if (type !== Object.prototype.toString.call(other)) {
        return false;
    }

    // If items are not an object or array, return false
    if (['[object Array]', '[object Object]'].indexOf(type) < 0) {
        return false;
    }

    // Compare the length of the length of the two items
    var valueLen = type === '[object Array]' ? value.length : Object.keys(value).length;
    var otherLen = type === '[object Array]' ? other.length : Object.keys(other).length;
    if (valueLen !== otherLen) {
        return false;
    }

    // Compare two items
    var compare = function (item1, item2) {

        // Get the object type
        var itemType = Object.prototype.toString.call(item1);

        // If an object or array, compare recursively
        if (['[object Array]', '[object Object]'].indexOf(itemType) >= 0) {
            if (!isEqual(item1, item2)) {
                return false;
            }
        }

        // Otherwise, do a simple comparison
        else {

            // If the two items are not the same type, return false
            if (itemType !== Object.prototype.toString.call(item2)) {
                return false;
            }

            // Else if it's a function, convert to a string and compare
            // Otherwise, just compare
            if (itemType === '[object Function]') {
                if (item1.toString() !== item2.toString()) {
                    return false;
                }
            } else {
                if (item1 !== item2) {
                    return false;
                }
            }

        }
    };

    // Compare properties
    if (type === '[object Array]') {
        for (var i = 0; i < valueLen; i++) {
            if (compare(value[i], other[i]) === false) {
                return false;
            }
        }
    } else {
        for (var key in value) {
            if (value.hasOwnProperty(key)) {
                if (compare(value[key], other[key]) === false) {
                    return false;
                }
            }
        }
    }

    // If nothing failed, return true
    return true;

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
