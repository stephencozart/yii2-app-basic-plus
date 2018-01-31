<template>
    <section :style="attributes.properties" :class="attributes.className" @click="setInspector">
        <component :attributes="child.attributes" v-for="child in children" :tag="child.tag ? child.tag : 'div'" v-bind:is="child.component" v-text="child.text"></component>
    </section>
</template>
<script>
    export default {
        props: [
            'children',
            'attributes'
        ],
        methods: {
            setInspector() {
                this.$store.commit('LAYOUT_INSPECTOR', this.attributes);
            }
        }
    }
</script>