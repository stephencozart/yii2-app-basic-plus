require('../../../bootstrap');
import axios from 'axios';
import Vue from 'vue';
import VeeValidate from 'vee-validate';
import Router from './router';
import Store from './store';
_.each(document.vuePlugins, (plugin) => {
    let c = plugin.component();
    Vue.component(c.name, c);
});
Vue.use(VeeValidate, {
    locale: 'en',
    dictionary: {
        en: {
            attributes: {
                first_name: 'First Name',
                last_name: 'Last Name'
            }
        },
    },
    validity: true
});
// components
import SideBar from './components/SideBar';
import Header from './components/Header';
import Checkbox from './components/Checkbox';
import Notifications from './components/Notifications';
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import { faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle, faTimesCircle, faExclamationTriangle, faTachometerAlt, faShareSquare } from '@fortawesome/fontawesome-free-solid';

fontawesome.library.add(faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle, faTimesCircle, faExclamationTriangle, faTachometerAlt, faShareSquare);

Vue.component('side-bar', SideBar);
Vue.component('app-header', Header);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('notifications', Notifications);
Vue.component(Checkbox);


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

