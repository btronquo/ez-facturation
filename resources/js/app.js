/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('admin-lte');

import VueRouter from 'vue-router';

window.Vue = require('vue');
Vue.use(VueRouter)

/**
 * Routes
 */
let routes = [
    { path: '/dashboard', component: require('./components/manager/Dashboard.vue').default },
    { path: '/profile', component: require('./components/user/Profile.vue').default },
    { path: '/customer', component: require('./components/manager/customers/Client.vue').default },
    { path: '/reference', component: require('./components/manager/references/Reference.vue').default },
    { path: '*', component: require('./components/404.vue').default }
];

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
