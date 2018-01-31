<template>
    <component v-bind:is="type" :style="inspectorStyles" :class="className" @click.stop="inspect" @handleDrop="handleDropHandler">
        {{ value }}
        <layout-element v-for="(child,ci) in children"
                   v-bind="child"
                   :key="child.tag ? child.tag : 'div'+'-'+ci"
                    v-model="child.text">
        </layout-element>
    </component>
</template>
<script>
    import Inspector from './Inspector';

    export default {
        components: {
            Inspector
        },
        name: 'layout-element',
        props: [
            'id',
            'uniqueId',
            'className',
            'displayName',
            'dropZone',
            'htmlId',
            'children',
            'styles',
            'type',
            'value'
        ],
        computed: {
            inspectorStyles() {
                return this.styles[this.deviceMode];
            },
            deviceMode() {
                return this.$store.state.deviceMode;
            }
        },

        mounted() {

            if (this.type === 'h1') {
                this.$el.onblur = () => {
                    this.$el.contentEditable = false;
                    this.$emit('input', this.$el.innerText);
                }
                this.$el.ondblclick = () => {
                    this.$el.contentEditable = true;
                    this.$el.focus();
                }
            }

            if (this.dropZone) {
                this.$el.ondrop = (event) => {
                    event.preventDefault();
                    console.log('drop');
                    this.$emit('handleDrop', {
                        owner: this,
                        type: event.dataTransfer.getData('text/plain')
                    });
                };
                this.$el.ondragover = (event) => {
                    event.preventDefault();
                    event.dataTransfer.dropEffect = "move"
                };
            }
        },
        methods: {
            inspect() {
                this.$store.commit('INSPECT', this);
            },
            handleDropHandler(data) {
                console.log('handledrop');
                console.log(data);
            }
        }
    }
</script>