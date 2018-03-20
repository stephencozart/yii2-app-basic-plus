<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        {{ choices }}
        <div class="select">
            <select :value="value ? value : ''" @click="$emit('input', $event.target.value)" @change="$emit('input', $event.target.value)" :disabled="disabled" :id="id" :name="name" class="form-control">
                <option value="">choose an option</option>
                <option v-for="option in choicesInternal" :value="option.value">{{ option.label ? option.label : option.name }}</option>
            </select>
        </div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'select-input',
        mixins: [BaseFieldMixin],
        props: [
            'options'
        ],
        data() {
            return {
                choicesInternal: this.options ? this.options : this.$formatChoices(this.choices)
            }
        }
    }
</script>