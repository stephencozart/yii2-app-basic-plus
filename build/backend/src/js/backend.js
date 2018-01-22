require('../../../bootstrap');
import axios from 'axios';
import Vue from 'vue';
import Router from './router';
import Store from './store';

// components
import SideBar from './components/SideBar';
import Header from './components/Header';

Vue.component('side-bar', SideBar);
Vue.component('app-header', Header);

// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const store = new Store();
const router = new Router();

if (window.app && window.app.user) {
    store.commit('USER', window.app.user);
}

Vue.prototype.$http = axios;

if (document.getElementById('app')) {
    const app = new Vue({
        store,
        router,
        methods: {
            toggleSidebar() {
                console.log('foo');
                document.body.classList.toggle('sidebar-open');
            }
        }
    }).$mount('#app');
}

