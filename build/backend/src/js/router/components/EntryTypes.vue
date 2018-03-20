<template>
    <div class="component entry-types">
        <header class="component-header" v-if="items.length > 0">
            <div class="component-header-main-group">
                <h1 class="component-title">Entry Types</h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">
                <router-link to="/entry-type/new" class="btn btn-primary btn-rounded">New Entry Type</router-link>
            </div>
        </header>
        <div class="component-body">
            <grid-view
                @tableRowClick="edit"
                :columns="columns"
                :data="items"
                v-if="items.length > 0">
            </grid-view>
            <empty-stage heading="Entry types" :content="missingContent" v-else>
                <router-link to="/entry-type/new" class="btn btn-primary btn-outline-primary btn-rounded">
                    Add your first Entry Type
                </router-link>
            </empty-stage>
        </div>
    </div>
</template>
<script>
    import GridView from '../../components/GridView'
    import EmptyStage from '../../components/EmptyStage'

    export default {
        components: {
            GridView,
            EmptyStage
        },
        mounted() {
            this.$http.get('/admin/entry-types').then((response) => {
               this.items = response.data.items;
               this.meta = response.data._meta;
               this.links = response.data._links;
            });
        },
        methods: {
            edit(item) {
                this.$router.push({
                    name: 'entry-type-update',
                    params: {
                        id: item.id
                    }
                })
            }
        },
        data() {
            return {
                columns: [
                    {
                        heading: 'Name',
                        key: 'name'
                    },
                    {
                        heading: 'Handle',
                        key: 'handle'
                    },
                    {
                        heading: 'Enabled',
                        key: 'enabled',
                        type: 'boolean'
                    },
                    /*{
                        heading: '',
                        type: 'action',
                        className: 'action-column',
                        buttons: {
                            edit: {
                                routeName: 'entry-type-update',
                                paramName: 'id',
                                key: 'id'
                            }
                        }
                    }*/
                ],
                items: [],
                meta: {},
                links: {},
                missingContent: 'Entry types are necessary for publishing content.'
            }
        }
    }
</script>