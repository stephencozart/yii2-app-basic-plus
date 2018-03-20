import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/Home.vue';
import Users from './components/Users.vue';
import User from './components/User.vue';
import MediaLibrary from './components/MediaLibrary';
import EntryType from './components/EntryType';
import EntryTypes from './components/EntryTypes';
import Entry from './components/Entry';
import Entries from './components/Entries';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: Home, name: 'home', props: { icon: 'tachometer-alt'} },
    { path: '/users', component: Users, name: 'users', props: { icon: 'users' } },
    { path: '/user/:id', component: User, name: 'edit-user', props: { icon: 'user' } },
    { path: '/user', component: User, name: 'add-user', props: { icon: 'user' } },
    { path: '/media-library', component: MediaLibrary, name: 'media-library', props: { icon: 'cloud-upload-alt'} },
    { path: '/media-library/:type', component: MediaLibrary, name: 'media-library-type', props: { icon: 'cloud-upload-alt'} },
    { path: '/entry-type/new', component: EntryType, name: 'entry-type-new' },
    { path: '/entry-type/:id', component: EntryType, name: 'entry-type-update' },
    { path: '/entry-types', component: EntryTypes, name: 'entry-types' },
    { path: '/entry/:type/edit/:entryId', component: Entry, name: 'edit-entry' },
    { path: '/entry/:type/new', component: Entry, name: 'new-entry' },
    { path: '/entries', component: Entries, name: 'entries' }
];

export default function create() {
    return new VueRouter({
        routes: routes
    })
}
