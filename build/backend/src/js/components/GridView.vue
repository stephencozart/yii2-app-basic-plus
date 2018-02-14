<template>
    <div class="grid-view">
        <table class="table">
            <thead>
            <tr>
                <th v-for="column in columns">{{ column.heading }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in data">
                <td v-for="column in columns">
                    <span @click="$emit('itemClick',{ key: column.key, data: item })">{{ item[column.key] }}</span>
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
        ]
    }
</script>