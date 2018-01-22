<template>
    <div class="sidebar">
        <div class="sidebar-avatar">
            <img :src="user.avatar" />
            <div class="user" @click.stop="showMenu = !(showMenu === true)">
                {{ user.first_name }} {{ user.last_name }}
                <svg aria-hidden="true" data-fa-processed="" data-prefix="fal" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="svg-inline--fa fa-angle-down"><path fill="currentColor" d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z" class=""></path></svg>
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
                            <svg aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="sign-out-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-sign-out-alt fa-w-16"><path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z" class=""></path></svg>
                            Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
                </transition>
            </div>
        </div>
        <div class="sidebar-nav">
            <router-link to="/">Dashboard </router-link>
            <router-link to="/users">Users</router-link>
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