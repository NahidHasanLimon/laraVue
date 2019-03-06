
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/* new Code*/
import moment from 'moment';
import{Form,HasError,AlertError} from 'vform';

import Gate from "./Gate";
Vue.prototype.$gate= new Gate(window.user);






window.Form=Form;
Vue.component(HasError.name,HasError)
Vue.component(AlertError.name,AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
// Start of Event code
window.Fire=new Vue();
 // End  of Event code

// Start of  Sweet Alert Code

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

// End of  Sweet Alert Code

 //Start of ProgressBar Code
 import VueProgressBar from 'vue-progressbar'

  Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})
 //End of ProgressBar Code
let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/developer', component: require('./components/Developer.vue').default },
  { path: '/invoice', component: require('./components/Invoice.vue').default },
  { path: '*', component: require('./components/NotFound.vue').default }
  ]

  const router = new VueRouter({
      mode: 'history',
      routes // short for `routes: routes`
    })
    //Start Filter  Code
    Vue.filter('uptext',function(text){
      return text.charAt(0).toUpperCase() + text.slice(1);
    });
   Vue.filter('mydate',function(created){
   return moment(created).format('MMMM Do YYYY');
 })
   //End of Filter  Code

// Example of Vue and passport
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
// Example of Vue and passport
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
      search:''
    },
    methods:{
      searchit:_.debounce(()=> {

        Fire.$emit('searching');
      },1000),
      printInvoice(){
        window.print();

      }
    }
});
