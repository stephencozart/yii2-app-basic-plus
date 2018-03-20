<template>
    <div :class="className + ' radio-list'">
        <label :for="id">{{ label }}</label>
        <div class="radio-wrapper" v-for="(radio, idx) in $formatChoices(choices)" :key="'radio-list-'+idx">
            <div class="pretty p-default p-round">
                <input type="radio" :name="'radio-list-'+idx" :value="radio.value" v-model="internalValue" @change="$emit('input', internalValue)">
                <div class="state p-primary">
                    <label>{{ radio.label }}</label>
                </div>
            </div>
        </div>
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'radio-button-input',
        mixins: [BaseFieldMixin],
        computed: {
            radioList() {
                return this.$formatChoices(this.choices);
            },
        },
        data() {
            return {
                internalValue: this.value ? this.value : this.default_value
            }
        }
    }
     
</script>
<style lang="scss">
@import '~pretty-checkbox/src/pretty-checkbox.scss';
.radio-list .pretty .state label:before, .radio-list .pretty .state label:after {
    width: 20px;
    height: 20px;
    line-height: 1.4rem;
}
.radio-list .pretty input:checked ~ .state.p-primary label:after, .radio-list .pretty.p-toggle .state.p-primary label:after {
    background-color: #91278c !important;
}
.radio-list {
    .pretty {
        .state {
            label {
                padding-left: 7px;
                font-weight: 500;
                &:before {
                    border: 2px solid #C8CCD4;
                }
            }
        }
        input[type="radio"] {
            &:checked {
                +.state {
                    label {
                        &:before {
                            border-color: #91278c;
                        }
                    }
                }
            }
        }
    }
}
</style>