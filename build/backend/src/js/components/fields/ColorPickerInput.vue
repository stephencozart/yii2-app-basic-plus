<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <div class="input-group color-swatch-input" @click.stop>
            <span class="color-swatch" :style="style">

            </span>
            <span class="input-group-addon">
                <button @click="show = !show" class="btn btn-outline-secondary">
                    <font-awesome-icon icon="caret-down" prefix="far"></font-awesome-icon>
                </button>
            </span>
            <sketch-picker v-if="show" v-model="color" @input="updateValue"></sketch-picker>
        </div>
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';
    import { Sketch } from 'vue-color';

    export default {
        name: 'color-picker-input',
        mixins: [BaseFieldMixin],
        components: {
            'sketch-picker': Sketch
        },
        mounted() {
            document.body.onclick = () => {
                console.log('bar');
                this.show = false;
            };
        },
        data() {
            return {
                show: false,
                color: this.value ? this.value : ''
            }
        },
        methods: {
            updateValue(value) {
                this.$emit('input', 'rgba('+value.rgba.r+','+value.rgba.g+','+value.rgba.b+','+value.rgba.a+')');
            }
        },
        computed: {
            rgba() {
                let value = this.color;
                return typeof value === 'string' ? value :'rgba('+value.rgba.r+','+value.rgba.g+','+value.rgba.b+','+value.rgba.a+')';
            },
            style() {
                return {
                    backgroundColor: this.rgba
                }
            }
        }
    }
</script>
<style lang="scss">
    .color-swatch-input {
        width: 76px;
        .vc-sketch {
            position: absolute;
            z-index: 1;
            left: 100%;
        }
    }
    .color-swatch {
        width: 38px;
        height: 38px;
        border: 1px solid #6c757d;
        border-right: none;
        display: inline-block;
        box-shadow: inset 0 0 0 4px #ffffff;
    }
</style>