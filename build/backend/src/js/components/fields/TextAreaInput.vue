<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
        <textarea :value="value" :id="id" :name="name" class="form-control" @input="$emit('input',$event.target.value)" @blur="$emit('blur', $event.target.value)"></textarea>
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'text-area-input',
        mixins: [BaseFieldMixin]
    }
</script>