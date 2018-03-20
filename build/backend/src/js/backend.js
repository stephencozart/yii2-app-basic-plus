require('../../../bootstrap');
import axios from 'axios';
import Vue from 'vue';
import VeeValidate from 'vee-validate';
import VueSweetAlert from 'vue-sweetalert'
import filters from './filters';
import fields from './fields';
import Router from './router';
import Store from './store';
import SideBar from './components/SideBar';
import Header from './components/Header';
import Checkbox from './components/Checkbox';
import Notifications from './components/Notifications';
import fontawesome from '@fortawesome/fontawesome'
import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome'
import { faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle, faTimesCircle,
    faExclamationTriangle, faTachometerAlt, faShareSquare, faCloudUploadAlt, faUpload, faFilm, faFile, faFolder } from '@fortawesome/fontawesome-free-solid';

import { faFile as faFileRegular } from '@fortawesome/fontawesome-free-regular';

fontawesome.library.add(faEdit, faAngleDown, faSignOutAlt, faAngleLeft, faAngleRight, faUsers, faUser, faCheckCircle,
    faTimesCircle, faExclamationTriangle, faTachometerAlt, faShareSquare, faCloudUploadAlt, faUpload, faFilm, faFile, faFolder, faFileRegular);

_.each(document.vuePlugins, (plugin) => {
    let c = plugin.component();
    Vue.component(c.name, c);
});

Vue.use(VueSweetAlert);

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
Vue.component('side-bar', SideBar);
Vue.component('app-header', Header);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('font-awesome-layers', FontAwesomeLayers);
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
if (window.app && window.app.roles) {
    store.commit('ROLES', window.app.roles);
}

Vue.prototype.$http = axios;

Vue.prototype.$formatChoices = function(choices) {
    let lines = choices.split("\n");
    let output = [];

    _.each(lines, (value) => {
        let parts = value.split(':');            
        output.push({
            label: parts[1] ? parts[1].trim() : parts[0].trim(),
            value: parts[0].trim()
        })
    });

    return output;
}

String.prototype.replaceUrlParam = function(param, value) {
    let url = this;
    let re = new RegExp("[\\?&]" + param + "=([^&#]*)", "i"), match = re.exec(url), delimiter, newString;

    if (match === null) {
        // append new param
        let hasQuestionMark = /\?/.test(url);
        delimiter = hasQuestionMark ? "&" : "?";
        newString = url + delimiter + param + "=" + value;
    } else {
        delimiter = match[0].charAt(0);
        newString = url.replace(re, delimiter + param + "=" + value);
    }

    return newString;
};

function nthIndex(str, pat, n) {
    let L = str.length, i= -1;
    while(n-- && i++<L) {
        i= str.indexOf(pat, i);
        if (i < 0) break;
    }
    return i;
}

String.prototype.convertUrlToRelative = function() {
    let url = this;
    let pos = nthIndex(url, '/', 3);
    return url.substring(pos);
};

String.prototype.slugify = function() {
    let value = this;
    value = value.replace(/^\s+|\s+$/g, ''); // trim
    value = value.toLowerCase();

    // remove accents, swap ñ for n, etc
    let from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    let to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (let i=0, l=from.length ; i<l ; i++) {
        value = value.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    value = value.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return value;
};

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
        },
        watch: {
            overlay(value) {            
                if (value) {
                    document.body.classList.add('lock-body');
                } else {
                    document.body.classList.remove('lock-body');
                }
            }
        }
    }).$mount('#app');
}

