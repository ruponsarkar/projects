
import Vue from 'vue';
// import router from './router';
import routes from './router';

// import Vuesax from 'vuesax';

  import 'vuesax/dist/vuesax.css'; //Vuesax styles

require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from '../plugins/vuetify';


import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

// Vue.use(Vuesax);


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('Students', require('./components/student/StudentsAttendance.vue').default);


const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router:routes,
    // Vuesax
    
});


