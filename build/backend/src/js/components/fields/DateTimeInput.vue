<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <div class="input-group">
            <flat-pickr :config="config" :readonly="readonly" :id="id" :name="name" v-model="date"></flat-pickr>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" title="Toggle" data-toggle>
                    <font-awesome-icon icon="calendar-alt" prefix="far"></font-awesome-icon>
                </button>
                <button class="btn btn-outline-secondary" type="button" title="Clear" data-clear>
                    <font-awesome-icon icon="calendar-times" prefix="far"></font-awesome-icon>
                </button>
            </div>
        </div>

        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        name: 'date-time-input',
        mixins: [BaseFieldMixin],
        components: {
            flatPickr
        },
        data() {
            return {
                date: this.value,
                config: {
                    wrap: true,
                    altFormat: 'F J, Y h:i K',
                    altInput: true,
                    dateFormat: 'Y-m-d H:i:S',
                    enableTime: true
                }
            }
        },

        watch: {
            date(value) {
                this.$emit('input', value);
            }
        }
    }
</script>