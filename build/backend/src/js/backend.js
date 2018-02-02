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
import LayoutElement from './components/LayoutElement';
import SideBar from './components/SideBar';
import Header from './components/Header';
import Checkbox from './components/Checkbox';
import Notifications from './components/Notifications';
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import { faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle, faTimesCircle,
    faExclamationTriangle, faTachometerAlt, faShareSquare, faCloudUploadAlt, faUpload, faFilm, faFile } from '@fortawesome/fontawesome-free-solid';

fontawesome.library.add(faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle,
    faTimesCircle, faExclamationTriangle, faTachometerAlt, faShareSquare, faCloudUploadAlt, faUpload, faFilm, faFile);

Vue.component('side-bar', SideBar);
Vue.component('app-header', Header);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('notifications', Notifications);
Vue.component('layout-element', LayoutElement);
Vue.component(Checkbox);



// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const store = new Store();
const router = new Router();

if (window.app && window.app.user) {
    store.commit('USER', window.app.user);
}
if (window.app && window.app.roles) {
    store.commit('ROLES', window.app.roles);
}

Vue.prototype.$http = axios;

window.store = store;

if (document.getElementById('app')) {
    const app = new Vue({
        store,
        router,
        methods: {
            toggleSidebar() {
                console.log('foo');
                document.body.classList.toggle('sidebar-open');
            },
            hideOverlay() {
                this.$store.commit('HIDE_OVERLAY');
            }
        },
        computed: {
            overlay() {
                return this.$store.state.overlay;
            }
        }
    }).$mount('#app');
}

