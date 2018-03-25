<template>
    <div class="component entry-types">
        <header class="component-header" v-if="items.length > 0">
            <div class="component-header-main-group">
                <h1 class="component-title">Entries</h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        New Entry
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a v-for="type in entryTypes" @click="newEntry(type)" class="dropdown-item">
                            {{ type.name }}
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="component-body">
            <grid-view
                    @tableRowClick="edit"
                    :columns="columns"
                    :data="items"
                    v-if="items.length > 0">
            </grid-view>
            <empty-stage heading="Entries" :content="missingContent" v-else>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        New Entry
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a v-for="type in entryTypes" @click="newEntry(type)" class="dropdown-item">
                            {{ type.name }}
                        </a>
                    </div>
                </div>

            </empty-stage>
        </div>
    </div>
</template>
<script>
    import GridView from '../../components/GridView'
    import EmptyStage from '../../components/EmptyStage'
    import Vue from 'vue'
    import EntryStatusIcon from '../../components/EntryStatusIcon'
    Vue.component('entry-status-icon', EntryStatusIcon)

    export default {
        components: {
            GridView,
            EmptyStage
        },
        mounted() {
            this.$http.get('/admin/entry-types').then((response) => {
                this.entryTypes = response.data.items;
                this.$http.get('/admin/entries?expand=published').then((response) => {
                    this.items = response.data.items;
                    this.meta = response.data._meta;
                    this.links = response.data._links;
                });
            });
        },
        methods: {
            edit(item) {
                this.$router.push({
                    name: 'edit-entry',
                    params: {
                        entryId: item.id,
                        type: item.entry_type_id
                    }
                })
            },
            newEntry(entryType) {
                this.$router.push({
                    name: 'new-entry',
                    params: {
                        type: entryType.id
                    }
                })
            }
        },
        data() {
            return {
                entryTypes: [],
                columns: [
                    {
                        heading: 'Status',
                        key: 'status',
                        type: 'component',
                        componentName: 'entry-status-icon'
                    },
                    {
                        heading: 'Title',
                        key: 'title'
                    },
                    {
                        heading: 'Handle',
                        key: 'handle',
                    },
                    {
                        heading: 'Last update',
                        key: 'updated_at',
                        type: 'dateTime'
                    }
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
                missingContent: 'No entry types have been added yet.'
            }
        }
    }
</script>