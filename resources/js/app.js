/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


window.EventBus = require('./EventBus').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)

files.keys().map(key => {
    // console.log(key, key.split('/').pop().split('.')[0])
    return Vue.component(key.split('/').pop().split('.')[0], files(key).default)
})

// Vue.component('status-form', require('./components/StatusForm.vue').default);
// Vue.component('statuses-list', require('./components/StatusesList.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Mixins
import AuthMixin from './mixins/auth.js'
Vue.mixin(AuthMixin)

const app = new Vue({
    el: '#app',
});
