import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/Home.vue';
import Users from './components/Users.vue';
import User from './components/User.vue';
import MediaLibrary from './components/MediaLibrary';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: Home, name: 'home', props: { icon: 'tachometer-alt'} },
    { path: '/users', component: Users, name: 'users', props: { icon: 'users' } },
    { path: '/user/:id', component: User, name: 'edit-user', props: { icon: 'user' } },
    { path: '/user', component: User, name: 'add-user', props: { icon: 'user' } },
    { path: '/media-library', component: MediaLibrary, name: 'media-library', props: { icon: 'cloud-upload-alt'}}
];

export default function create() {
    return new VueRouter({
        routes: routes
    })
}
