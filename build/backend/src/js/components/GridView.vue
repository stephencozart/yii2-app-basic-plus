<template>
    <div class="grid-view">
        <table class="table">
            <thead>
            <tr>
                <th v-for="column in columns">{{ column.heading }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in data" @click="$emit('tableRowClick', item)">
                <td v-for="column in columns" :class="column.className">
                    <span v-if="column.type === 'action'">
                        <a @click.stop="edit(column.buttons.edit, item)" v-if="column.buttons && column.buttons.edit" class="btn btn-light btn-sm btn-rounded edit">
                            <font-awesome-icon icon="edit"></font-awesome-icon>
                            edit
                        </a>
                    </span>
                    <span v-if="column.type === 'boolean'">
                        {{ item[column.key] === 1 ? 'Yes' : 'No' }}
                    </span>
                    <span v-if="column.type === 'dateTime'">
                        {{ item[column.key] | humanizeDate }}
                    </span>
                    <component v-bind:is="column.componentName" :item="item" v-if="column.type === 'component'">

                    </component>
                    <span v-if="!column.type" @click.stop="$emit('itemClick',{ key: column.key, data: item })">{{ item[column.key] }}</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: [
            'columns',
            'data'
        ],
        methods: {
            edit(route, item) {
                let params = {};
                if (route.paramName) {
                    params[route.paramName] = item[route.key];
                }
                this.$router.push({
                    name: route.routeName,
                    params: params
                })
            }
        }
    }
</script>