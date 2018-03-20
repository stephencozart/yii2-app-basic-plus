<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <checkbox v-for="(choice, idx) in choiceValues" :key="'choice-'+idx" :id="'choice-'+idx">
            <input slot="input" type="checkbox" :id="'choice-'+idx" :value="choice.value" v-model="values" />
            <span slot="label">{{ choice.label }}</span>
        </checkbox>
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';
    import Checkbox from '../Checkbox';

    export default {
        components: {
            Checkbox
        },
        name: 'checkbox-input',
        mixins: [BaseFieldMixin],
        data() {
            return {
                values: this.value ? this.value : []
            }
        },
        watch: {
            values(value) {
                this.$emit('input', value ? value : []);
            }
        },
        computed: {
            choiceValues() {            
                return this.$formatChoices(this.choices);
            }
        }
    }
     
</script>