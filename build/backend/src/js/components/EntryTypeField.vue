<template>
    <div class="configure-field">
        <div class="configure-field-header">
            Configure Field        
        </div>
        <div class="configure-field-body">
            
                
            <text-input
                @blur="createHandle"
                v-model="model.label"
                v-validate="'required|max:100'"
                :error="errors.first('Label')"
                :required="true"
                label="Label"
                name="Label">
            </text-input>
            
            <text-input
                    v-model="model.handle"
                    v-validate="'required|max:100'"
                    :error="errors.first('Handle')"
                    instructions="Use only alpha numeric characters.  Dashes and underscores are also allowed."
                    label="Handle"
                    name="Handle">
            </text-input>
            <div class="form-group">
                <checkbox id="field-required">
                    <input slot="input" type="checkbox" id="field-required" v-model="model.required" />
                    <span slot="label">Required</span>
                </checkbox>
            </div>
            <select-input
                    v-model="model.field_type_handle"
                    v-validate="'required|max:100'"
                    :error="errors.first('Type')"
                    :required="true"
                    label="Type"
                    :options="fieldTypes"
                    :disabled="model.id"
                    name="Type">
            </select-input>
            <div v-if="fieldType.choices">                    
                <text-area-input
                        v-model="model.choices"
                        :error="errors.first('Choices')"
                        instructions="Enter choices one per line.  If you need to specify specific keys a singular option would look something link red: Red"
                        label="Choices"
                        name="Choices">
                </text-area-input>
            </div> 
                    
            <text-input
                    v-model="model.placeholder"
                    v-validate="'max:100'"
                    :error="errors.first('Placeholder')"
                    instructions="Appears as text within the input."
                    label="Placeholder"
                    name="Placeholder">
            </text-input>
            
        
              

            <div class="form-group">
                <button @click="$emit('close')" class="btn btn-lg btn-light">Cancel</button>
                <button @click="save" class="btn btn-lg btn-primary">Save</button>
            </div>                 
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'entryType',
            'field'
        ],
        methods: {
            createHandle(value) {
                this.model.handle = this.model.handle.length === 0 ? value.slugify() : this.model.handle;
            },
            getModel() {
                if (this.model.id) {
                    this.$http.get('/admin/entry-type-fields/'+this.model.id).then((response) => {
                       this.model = response.data;
                    });
                }
            },
            save() {
                this.model.entry_type_handle = this.entryType.handle;
                let request;
                if (this.model.id) {
                    request = this.$http.put('/admin/entry-type-fields/'+ this.model.id, this.model);
                } else {
                    request = this.$http.post('/admin/entry-type-fields', this.model);
                }
                request.then((response) => {
                    this.$store.dispatch('pushSuccessNotification', 'Changes saved!');
                    this.$emit('save', response.data);            
                }).catch((error) => {
                    this.$store.dispatch('pushErrorNotification', error.response.statusText)
                });
            }
        },
        computed: {
            supportsChoices() {
                return this.fieldType.choices;
            },
            fieldType() {
                let fieldType = _.find(this.fieldTypes, (obj) => {                
                    return obj.value === this.model.field_type_handle;
                });
                return fieldType ? fieldType : {};
            },
            fieldTypes() {
                return this.$store.state.fieldTypes;
            }
        },
        mounted() {
            this.getModel()
        },
        data() {
            let m = {
                    entry_type_handle: '',
                    field_type_handle: 'text-input',            
                    handle: '',
                    parent: '',
                    label: '',
                    required: false,
                    instructions: '',
                    placeholder: '',
                    default_value: '',
                    choices: '',
                    min: null,
                    max: null,
                    step: null,
                    pattern: '',
                    searchable: false,
                    repeat_max: 3,
                    prepend: '',
                    append: '',
                    layout: 'col-12',
                    children: []
                };
            if (this.field) {
                m = this.field;
            }

            return {
            
                model: m,
            }
        }
    }
</script>
<style lang="scss">    
    .configure-field-body {
        padding: .5rem 1rem;
        .form-group {
            .hint-block {
                font-size: 14px;
                line-height: normal;
            }
            padding-bottom: 1rem;
        }
        .btn {
            min-width: 125px;
            text-align: center;
            border-radius: 2px;
        }
    }
    .configure-field-header {
        padding: .5rem 1rem;
        font-weight: bold;
        border-bottom: 1px solid #dddddd;        
    }
   
</style>