<template>
    <div class="sidebar">

        <div class="sidebar-avatar">
            <img :src="user.avatar" />
            <div class="user" @click.stop="showMenu = !(showMenu === true)">
                {{ user.first_name }} {{ user.last_name }}
                <font-awesome-icon icon="angle-down"></font-awesome-icon>
                <transition
                        name="app-transition"
                        enter-active-class="animated fadeInDown"
                        leave-active-class="animated fadeOutUp"
                        appear
                >
                <div v-if="showMenu" class="menu" @click.stop>
                    <ul>
                        <li>
                            <a @click="signOut">
                                <font-awesome-icon icon="sign-out-alt"></font-awesome-icon>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
                </transition>
            </div>
        </div>
        <div class="sidebar-nav">
            <router-link to="/"><font-awesome-icon icon="tachometer-alt"></font-awesome-icon> Dashboard </router-link>
            <router-link to="/users"><font-awesome-icon icon="users"></font-awesome-icon> Users</router-link>
            <router-link to="/file-manager"><font-awesome-icon icon="cloud-upload-alt"></font-awesome-icon> File Manager </router-link>
        </div>
        <div class="sidebar-overlay" @click="$emit('toggle')">
            <button class="sidebar-close">X</button>
        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            user() {
                return this.$store.state.user;
            }
        },
        data() {
            return {
                showMenu: false
            }
        },
        mounted() {
            document.onclick = () => {
                this.showMenu = false;
            }
        },
        methods: {
            signOut() {
                this.$http.post('/admin/app/logout').then((response) => {
                   window.location.href = '/admin/app/login';
                });
            }
        }
    }
</script>