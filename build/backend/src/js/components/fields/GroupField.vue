<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>
        <draggable :options="{draggable:'.group-field-set', clone: false}" v-model="sets" @end="emitValues" @click.stop>
        <div v-for="(set,setIdx) in sets" class="group-field-set">
            <div v-for="field in set" class="group-field-set-fields">
                <component
                        v-bind:is="field.field_type_handle"
                        v-bind="field"                    
                        v-model="field.value"                        
                        :name="field.handle"
                        @input="emitValues"
                        :key="'group-field-' + setIdx + '-' + field.handle">
                </component>
            </div>
            
        </div>
        </draggable>
        <div class="group-field-add">
            <button @click="addAnother" class="btn btn-light btn-block">
                <font-awesome-icon size="2x" icon="plus" prefix="far"></font-awesome-icon>
            </button>
        </div>
        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';
    import draggable from 'vuedraggable'

    export default {
        name: 'group-field',
        mixins: [BaseFieldMixin],
        components: {
            draggable
        },
        props: [
            'children'
        ],
        data() {
            let sets = [];
            if (this.value) {
                sets = JSON.parse(this.value);
            }
            return {
                sets: sets
            }
        },
        
        methods: {
            emitValues() {
                let sets = [];
                _.each(this.sets, (set) => {
                    let val = {};
                    _.each(set, (field) => {
                        val[field.handle] = field.value;
                    });
                    sets.push(val);
                });

                this.$emit('input', JSON.stringify(sets));
            },
            model(idx, handle) {
                return this.values[idx] && this.values[idx][handle] ? this.values[idx][handle] : '';
            },
            addAnother() { 
                    
                let children = [];
                _.each(this.children, (child) => {                    
                    children.push(JSON.parse(JSON.stringify(child)));
                })
            
                this.sets.push(children);
            },
            createValidationRules(field) {
                let rules = [];
                if (field.required) {
                    rules.push('required')
                }
                let rule = rules.join('|');
                return rule;
            }
        }
    }
</script>
<style lang="scss">
.group-field-set {
    padding-left: 1rem;
    border-left: 2px solid #aaaaaa;
    margin-left: 1rem;
    padding-bottom: 1.5rem;

    .group-field-set-fields {
        &:last-child {
            .form-group {
                margin-bottom: 0;
            }            
        }
    }

    +.group-field-set {
        border-top: 1px dashed #aaaaaa;
        padding-top: 1rem;
    }
}   
.group-field-add {
    margin-top: 1rem;
    .btn {
        border-radius: 5px;
        border: 3px dashed #C8CCD4;
        color: #C8CCD4;    
        font-weight: bolder;
        padding: .75rem;
    }
}
.sortable-ghost {
    opacity: .3;
    outline: 1px dashed #000000;
}
</style>