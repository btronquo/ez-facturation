require('./bootstrap');
require('admin-lte');

window.Vue = require('vue');

/**
 * MomentJs
 */
import moment from 'moment';
moment.locale('fr');

/**
 * vForm (validation)
 */
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

/**
 * pagination
 */
Vue.component('pagination', require('laravel-vue-pagination'));


/**
 * Sweetalert2 (alert & toast)
 */
import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});
window.toast = toast;

/**
 * Vue-Progressbar
 */
import VueProgressBar from 'vue-progressbar';

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
}
Vue.use(VueProgressBar, options);

/**
 * VueRouter
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter)

let routes = [
    { path: '/billing', component: require('./components/billing/Billing.vue').default },
    { path: '/invoice-generation', component: require('./components/billing/Invoice.vue').default },
    { name: 'invoice-result', path: '/invoice-result', component: require('./components/billing/InvoiceResult.vue').default },
    { path: '/home', component: require('./components/manager/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/manager/Dashboard.vue').default },
    { path: '/settings', component: require('./components/settings/Settings.vue').default },
    { path: '/customer', component: require('./components/manager/customers/Client.vue').default },
    { path: '/reference', component: require('./components/manager/references/Reference.vue').default },
    { path: '*', component: require('./components/404.vue').default }
];
const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});

/**
 * Vue Filter configuration
 */
// Make UpperCase to the first letter of a string
Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})

// Transform a datetime
Vue.filter('myDate', function (date) {
  return moment(date).format('Do MMMM YYYY, HH:mm:ss');
})

// Truncate text
Vue.filter('truncate', function (text, stop, clamp) {
  return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
})

/**
 * Global event listener
 */
window.Event = new Vue();


/**
 * Example components for passport
 */
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

/**
 * VueJs Declaration
 */
const app = new Vue({
    el: '#app',
    router,
    data: {
      inputSearch: ''
    },
    methods: {
      search: _.debounce(() =>{
        Event.$emit('search')
      },500)
    }
});
