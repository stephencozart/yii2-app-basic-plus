<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <input type="number" step="1" @keypress="limitInteger" :readonly="readonly" :value="value" :id="id" :name="name" class="form-control" @input="$emit('input',$event.target.value)" @blur="$emit('blur', $event.target.value)" />
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'integer-input',
        mixins: [BaseFieldMixin],
        methods: {
            limitInteger: function(evt) {
                console.log(evt);
                evt = (evt) ? evt : window.event;
                let charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode === 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        }
    }
</script>
