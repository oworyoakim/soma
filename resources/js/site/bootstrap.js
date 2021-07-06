import Vue from "vue";

window.$ = window.jQuery = require("./theme/js/jquery.min.js");
require("./theme/js/popper.min.js");
require("./theme/js/bootstrap.min.js");
require("./theme/js/script.js");

try {
    // Moment
    window.moment = Vue.prototype.$moment = require('moment');
    // Numeral
    window.numeral = Vue.prototype.$numeral = require('numeral');
} catch (error) {
    console.error(error);
}
