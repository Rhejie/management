require('./bootstrap');
 import Vue from 'vue'
 import '@fortawesome/fontawesome-free'
 import 'bootstrap-icons/font/bootstrap-icons.css'
 import 'vue-bootstrap-sidebar/src/scss/default-theme.scss';
 
 import 'vue-search-select/dist/VueSearchSelect.css'
 import '../css/vue-select-css.css'
 
 import router from './router/index'
 import store from './store/index'
 import './plugins/axios'
 import Navigation from './components/layouts/Navigation';

 Vue.config.productionTip = false;
 
 new Vue({
     el: '#app',
     router,
     store,
     components: {
         Navigation
     }
 })

 window.Vue = require('vue').default;
 