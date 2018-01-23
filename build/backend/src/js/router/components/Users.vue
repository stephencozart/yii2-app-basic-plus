<template>
    <div class="component users">
        <header class="component-header">
            <div class="component-header-main-group">

                <h1 class="component-title">
                    <font-awesome-icon :icon="icon"></font-awesome-icon>
                    <strong>{{ meta.totalCount }}</strong>
                    {{ title }}
                </h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">
                <router-link class="btn btn-primary btn-rounded" to="/user">Add User</router-link>
            </div>
        </header>
        <div class="component-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items">
                        <td>
                            <img class="img-circle" :src="item.avatar" />
                            {{ item.email }}
                        </td>
                        <td>
                            {{ item.first_name }} {{ item.last_name }}
                        </td>
                        <td class="actions">
                            <a class="edit" @click="edit(item)">edit <font-awesome-icon icon="edit"></font-awesome-icon></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="component-footer">
            <pager :links="links" @next="fetchUsers" @previous="fetchUsers"></pager>
        </div>
    </div>
</template>
<script>
    import Pager from '../../components/Pager';
    export default {
        components: {
            Pager
        },
        props: [
            'icon'
        ],
        data() {
            return {
                items: [],
                meta: {

                },
                links: {

                }
            }
        },
        computed: {
          title() {
            return this.meta.totalCount === 1 ? 'User' : 'Users';
          }
        },
        mounted() {
            this.fetchUsers();
        },
        methods: {
            fetchUsers(url) {
                url = !url ? '/admin/users' : url;
                this.$http.get(url).then((response) => {
                   this.items = response.data.items;
                   console.log(response.data);
                   this.meta = response.data._meta;
                   this.links = response.data._links;
                });
            },
            edit(user) {
                console.log(user);
                this.$router.push({ name: 'edit-user',  params: { id: user.id } });
            }
        }
    }
</script>