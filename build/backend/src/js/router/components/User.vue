<template>
    <div class="component user">
        <div class="component-bread-crumbs">
            <router-link to="/users"><font-awesome-icon icon="angle-left"></font-awesome-icon> Users</router-link>
        </div>
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">{{ title }}</h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">

            </div>
        </header>
        <div class="component-body">
            {{ $route.name }}
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        computed: {
            title() {
                return this.$route.name === 'add-user' ? 'Add User' : 'User';
            }
        }
    }
</script>