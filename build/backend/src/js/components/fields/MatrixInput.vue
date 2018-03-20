<template>
    <div class="row matrix-field">
        <div :class="field.layout" v-for="field in fields">
            <component
                    v-bind:is="field.field_type_handle"
                    v-bind="field"
                    :name="field.handle"
                    :key="'field-'+field.handle">
            </component>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'fields',
            'value'
        ]
    }
</script>