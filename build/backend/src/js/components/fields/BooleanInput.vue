<template>
    <div :class="className">
        <label>{{ label }}</label>
        <div class="toggle-switch">
            <div class="pretty p-switch">
                <input :checked="value" @change="$emit('input', $event.target.checked)" type="checkbox" />
                <div class="state">
                    <label>&nbsp;</label>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'boolean-input',
        mixins: [BaseFieldMixin]
    }
     
</script>
<style lang="scss">
@import '~pretty-checkbox/src/pretty-checkbox.scss';
.toggle-switch .pretty .state label:before, .toggle-switch .pretty .state label:after {
    width: 20px;
    height: 20px;
    line-height: 1.4rem;
}
.pretty.p-switch .state:before {
    border-color: #C8CCD4;
    box-shadow: 0 0 0 1px #C8CCD4;
}
.pretty.p-switch .state label:after {
    background-color: #C8CCD4;
}
.pretty.p-switch input:checked ~ .state label:after {
    background-color: #91278c !important;
}
.pretty.p-switch input:checked ~ .state:before {
    border-color: #91278c !important;
    box-shadow: 0 0 0 1px #91278c;
}
</style>