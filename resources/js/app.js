require('./bootstrap');

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import {ValidationProvider, ValidationObserver, extend} from "vee-validate";
import {messages} from 'vee-validate/dist/locale/pt_BR.json';
import * as rules from "vee-validate/dist/rules";
import VueResource from 'vue-resource';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Object.keys(rules).forEach(rule => {
    extend(rule, {
      ...rules[rule], // copies rule configuration
      message: messages[rule] // assign message
    });
});

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueResource)
Vue.use(VueToast)

import router from './router';
import store from './stores';

import App from './layouts/App.vue';

new Vue({
    store,
    router,
    el: '#app',
    render: h => h(App)
});

Vue.config.productionTip = false;
