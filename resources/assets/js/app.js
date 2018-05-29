/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

let moment = require('moment');

exports.install = function (Vue, options) {
    Vue.prototype.moment = function (...args) {
        return moment(...args);
    };
    Vue.prototype.Echo = function (...args) {
        return Echo(...args);
    };
}

Vue.use(exports);

Vue.component('tasks-component', require('./components/TasksComponent.vue'));

const app = new Vue({
    el: '#app'
});