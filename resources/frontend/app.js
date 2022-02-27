require('./bootstrap');
import Vue from 'vue'
import {initialize} from './customer/helpers/authHelper'
import VueProgressBar from 'vue-progressbar'
/**
 * vue router configuration
 */
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import {routes} from './routes'

const router = new VueRouter({
    routes,
    mode: 'history'
});
initialize(router);

import Vuex from 'vuex'
Vue.use(Vuex)
const store =  new Vuex.Store({})

// initialize(router);

//vue progressbar
const options = {
    color: '#1eb885',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}
  
Vue.use(VueProgressBar, options)
// loader
import inlineLoader from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(inlineLoader, {
    // Optional parameters
    loader: 'dots',
    backgroundColor: '#000',
    color: '#fff'
});

import swal from 'sweetalert2'
window.swal = swal

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: false,
})
window.toast = toast


// =============================================================================
// Meta Information call
// =============================================================================
 
import VueMeta from 'vue-meta';
Vue.use(VueMeta, { 
    refreshOnceOnNavigation: true
})
import LoadScript from 'vue-plugin-load-script';
 
  Vue.use(LoadScript);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#lynktoVueApp',
    components: {
        frontendlayout: () => import(/* webpackChunkName: "js/frontendlayout" */ './layouts/Default.vue'),
    },
    router,
    store
});
