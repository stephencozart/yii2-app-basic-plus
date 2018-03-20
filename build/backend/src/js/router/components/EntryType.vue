<template>
    <div class="component entry-type">
        <div class="component-bread-crumbs">
            <router-link to="/entry-types"><font-awesome-icon icon="angle-left"></font-awesome-icon> Entry Types</router-link>
        </div>
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">{{ componentTitle }}</h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">
                <button @click="save" class="btn btn-primary btn-rounded">Save</button>
            </div>
        </header>
        <div class="component-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <text-input
                                    @blur="createHandle"
                                    v-model="model.name"
                                    v-validate="'required'"
                                    id="entry-type-name"
                                    :required="true"
                                    :error="errors.first('Name')"
                                    name="Name"
                                    label="Name">
                            </text-input>

                            <text-input
                                    :readonly="$route.params.id > 0"
                                    v-model="model.handle"
                                    v-validate="'required|alpha_dash'"
                                    id="entry-type-handle"
                                    :required="true"
                                    :error="errors.first('Handle')"
                                    name="Handle"
                                    label="Handle">
                            </text-input>

                            <rich-text
                                    v-model="model.content"
                                    label="Content">
                            </rich-text>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6>Search engine optimization</h6>

                            <text-input
                                    v-model="model.meta_title"
                                    v-validate="'max:70'"
                                    id="entry-type-meta_title"
                                    :error="errors.first('MetaTitle')"
                                    name="MetaTitle"
                                    label="Meta Title">
                            </text-input>

                            <text-area-input
                                    v-model="model.meta_description"
                                    v-validate="'max:70'"
                                    id="entry-type-meta_description"
                                    :error="errors.first('MetaDescription')"
                                    name="MetaDescription"
                                    label="Meta Description">
                            </text-area-input>

                            <div v-if="metaTitle">
                                <hr class="card-divider">
                                <h6>Search engine listing preview</h6>

                                <seo-preview :title="metaTitle" :description="model.meta_description" :url="url">
                                </seo-preview>
                            </div>



                        </div>
                    </div>

                </div>
                <div class="col-md-4 ml-auto">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <checkbox id="entry-type-enable">
                                    <input slot="input" type="checkbox" id="entry-type-enable" v-model="model.enabled" />
                                    <span slot="label">Enabled</span>
                                </checkbox>
                            </div>

                            <select-input
                                    v-model="model.default_sort"
                                    v-validate="'required'"
                                    id="entry-type-sort"
                                    :required="true"
                                    :error="errors.first('Default_Sort')"
                                    name="Default_Sort"
                                    label="Default Sort"
                                    :options="sortOptions">
                            </select-input>

                            <text-input
                                    v-model="model.items_per_page"
                                    v-validate="'required|numeric'"
                                    id="entry-type-ipp"
                                    :required="true"
                                    :error="errors.first('ItemsPerPage')"
                                    name="ItemsPerPage"
                                    label="Items Per Page">
                            </text-input>

                            <div class="meta-data" v-if="showMeta">
                                <hr class="card-divider">
                                <div class="d-flex justify-content-between">
                                    <strong class="text-muted">Created:</strong> {{ model.created_at | humanizeDate }}
                                </div>
                                <div class="d-flex justify-content-between">
                                    <strong class="text-muted">Last Updated:</strong> {{ model.updated_at | humanizeDate }}
                                </div>
                            </div>

                            <div class="fields" v-if="$route.params.id">
                                <hr class="card-divider">
                                <h6>Fields</h6>

                                <draggable :options="{draggable:'.field-list-item', clone: false}" class="field-list" v-model="model.fieldRegistry" @end="saveFieldSort" @click.stop>
                                    <div :key="'field-'+field.id" v-for="(field, fieldIdx) in model.fieldRegistry" class="field-list-item">
                                        <font-awesome-icon icon="bars"></font-awesome-icon>
                                        <span>
                                            {{ field.label }}
                                            <br>
                                            <small>{{ field.field_type_handle }}</small>
                                        </span>
                                        <div @click.stop class="btn-group ml-auto">
                                            <a class="text-danger" @click="deleteField(fieldIdx)">
                                                <font-awesome-icon icon="trash-alt" prefix="far"></font-awesome-icon>
                                            </a>
                                            <a style="margin-left: .5rem;" @click="fieldContext = field">
                                                <font-awesome-icon icon="cog" prefix="far"></font-awesome-icon>                                                    
                                            </a>                                        
                                        </div>
                                        <div class="group-field-drop" v-if="field.field_type_handle === 'group-field'">
                                            <div class="group-field-drop-inner bg-light">
                                                <div class="group-field-container">
                                                    <draggable :options="{draggable:'.field-list-item', clone: false}" class="field-list" v-model="field.children" @end="saveChildFieldSort(field.children)" @click.stop>
                                                    <div class="field-list-item" v-for="(child, childIdx) in field.children">
                                                        <font-awesome-icon icon="bars"></font-awesome-icon>
                                                        <span style="margin-left: .5rem;">
                                                            {{ child.label }}
                                                            <br>
                                                            <small>{{ child.field_type_handle }}</small>
                                                        </span>                                                        
                                                        <div @click.stop class="btn-group ml-auto">
                                                            <a class="text-danger" @click="deleteChildField(field, childIdx)">
                                                                <font-awesome-icon icon="trash-alt" prefix="far"></font-awesome-icon>
                                                            </a>
                                                            <a style="margin-left: .5rem;" @click="fieldContext = child">
                                                                <font-awesome-icon icon="cog" prefix="far"></font-awesome-icon>                                                    
                                                            </a>                                        
                                                        </div>
                                                    </div>
                                                    </draggable>
                                                </div>
                                                <div class="group-field-add">
                                                    <button @click="addSubField(field)" class="btn btn-light">
                                                        <font-awesome-icon icon="plus" prefix="far"></font-awesome-icon>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>

                                <p v-if="model.fieldRegistry.length === 0">
                                    No fields added yet
                                </p>

                                <button @click="$store.commit('SHOW_OVERLAY')" class="btn btn-primary btn-block">
                                    <font-awesome-icon icon="plus" prefix="far"></font-awesome-icon>
                                    Add Field
                                </button>                        
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="component-footer">
            <button v-if="$route.params.id" @click="deleteEntryType" class="btn btn-danger btn-rounded">Delete</button>
            <button @click="save" class="btn btn-primary btn-rounded">Save</button>
        </div>
        <right-panel v-if="overlay">
            <entry-type-field @save="handleFieldSave" @close="$store.commit('HIDE_OVERLAY')" :field="fieldContext" :entry-type="model"></entry-type-field>
        </right-panel>
    </div>
</template>
<script>
    import SeoPreview from '../../components/SeoPreview'
    import draggable from 'vuedraggable'
    import RightPanel from '../../components/RightPanel'
    import EntryTypeField from '../../components/EntryTypeField'

    export default {
        components: {
            SeoPreview,
            draggable,
            RightPanel,
            EntryTypeField
        },
        methods: {

            addSubField(parentField) {
                this.fieldContext = {
                    parent: parentField.handle,
                    entry_type_handle: '',
                    field_type_handle: 'text-input',            
                    handle: '',                
                    label: '',
                    required: false,
                    instructions: '',
                    placeholder: '',
                    default_value: '',
                    choices: '',
                    layout: 'col-12',
                    children: []                  
                }
            },
            handleFieldSave() {
                this.$store.commit('HIDE_OVERLAY');
                this.loadModel();
            },
            save() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let request;
                        if (this.$route.params.id) {
                            request = this.$http.put('/admin/entry-types/'+this.$route.params.id, this.model);
                        } else {
                            request = this.$http.post('/admin/entry-types', this.model);
                        }

                        request.then((response) => {
                            this.$router.push('/entry-type/'+response.data.id)
                        });
                    }
                });
            },
            saveChildFieldSort(fields) {
                this.$http.put('/admin/entry-types/sort-fields/'+this.model.id, fields).then((response) => {

                });
            },
            saveFieldSort() {
                this.$http.put('/admin/entry-types/sort-fields/'+this.model.id, this.model.fieldRegistry).then((response) => {

                });
            },
            deleteEntryType() {
                this.$swal({
                    title: 'Are you sure?',
                    text: "Doing this will also delete all associated fields and entries.  You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result) {
                        this.$http.delete('/admin/entry-types/'+this.$route.params.id).then((response) => {
                            this.$router.push({
                                name: 'entry-types'
                            });
                            this.$store.dispatch('pushSuccessNotification', 'Entry type deleted!')
                        }).catch((error) => {
                            this.$swal(
                                'Delete failed!',
                                error.response.statusText,
                                'error'
                            )
                        });


                    }
                }).catch((result) => {

                });
            },
            createHandle(value) {
                this.model.handle = this.model.handle.length === 0 ? value.slugify() : this.model.handle;
            },
            setContext(field) {
                
                this.context = field;
                
            
                this.$nextTick(() => {                
                    let ele = this.$refs['ddMenuContext-'+field.id][0];
                    let left = ele.offsetWidth;                
                    ele.style.transform = 'translate3d(-' + left + 'px, 0px, 0px)';
                    ele.style.willChange = 'transform'
                    ele.style.top = 0;    
                });
            },
            deleteField(fieldIdx) {
                let field = this.model.fieldRegistry[fieldIdx];

                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result) {
                        this.$http.delete('/admin/entry-type-fields/'+field.id).then((response) => {
                            this.model.fieldRegistry.splice(fieldIdx, 1);
                            this.context = {};
                            this.$swal(
                                'Deleted!',
                                'Field has been deleted.',
                                'success'
                            )
                        }).catch((error) => {
                            this.$swal(
                                'Delete failed!',
                                error.response.statusText,
                                'error'
                            )
                        });


                    }
                }).catch((result) => {

                });
            },
            loadModel() {
                if (this.$route.params.id) {
                    this.$http.get('/admin/entry-types/'+this.$route.params.id).then((response) => {
                        this.model = response.data;
                    });
                }
            }
        },
        watch: {
            fieldContext(value) {
                this.context = {};
                if (value) {
                    this.$store.commit('SHOW_OVERLAY');
                }
            },
            overlay(value) {
                if (value === false) {
                    this.fieldContext = null;
                }
            }
        },
        mounted() {
            this.loadModel();
            document.body.onclick = () => {
                this.context = {};
            }
        },
        data() {
            return {            
                context: {},
                fieldContext: null,
                sortOptions: [
                    {
                        value: '-created_at',
                        name: 'Created At: New to Old'
                    },
                    {
                        value: 'created_at',
                        name: 'Created At: Old to New'
                    }
                ],
                model: {
                    name: '',
                    handle: '',
                    enabled: true,
                    default_sort: '-created_at',
                    content: '',
                    items_per_page: 20,
                    meta_title: '',
                    meta_description: '',
                    created_at: '',
                    updated_at: '',
                    fieldRegistry: []
                }
            }
        },
        computed: {
            overlay() {
                return this.$store.state.overlay;
            },
            name() {
                return this.model.name;
            },
            content() {
                return this.model.content;
            },
            metaTitle() {
                return this.model.meta_title.length > 0 ? this.model.meta_title : this.model.name;
            },
            url() {                
                let parts =  [window.location.origin, this.model.handle];
                return parts.join('/');
            },
            showMeta() {
                return this.model.created_at || this.model.updated_at;
            },
            componentTitle() {
                return this.$route.params.id ? 'Edit Entry Type' : 'New Entry Type';
            }
        }
    }
</script>
<style lang="scss">
    .card {
        +.card {
            margin-top: 1rem;
        }
    }
    .sortable-ghost {
        opacity: .3;
        outline: 1px dashed #000000;
    }
    .field-list-item {
        padding: .25rem .5rem;
        margin-left: -.5rem;
        margin-right: -.5rem;
        margin-bottom: .5rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        color: #aaaaaa;
        span {
            color: #4a4a4a;
            margin-left: 1rem;
            line-height: 1;
            font-size: .9rem;
            small {
                opacity: .5;
            }
        }  
        .btn-group {
            a {
                font-size: smaller;
            }
        }
    }
    .field-list {
        margin-bottom: .75rem;
    }
    .component-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    .group-field-drop {
        flex: 0 0 100%;
        padding-bottom: 1.2rem;
        .field-list-item {
            margin-bottom: .5rem;          
        }
        .group-field-drop-inner {
            margin-top: 1rem;
            margin-left: 1.5rem;
            background-color: #eeeeee;
            padding: .5rem 1rem;
            border-left: 5px solid #aaaaaa;
            .group-field {
                padding: .5rem;
                
            }
            .group-field-add {
                text-align: center;
                margin-bottom: -1.5rem;
                .btn {
                    border-radius: 50%;
                    box-shadow: 0 0 0 2px #aaaaaa;
                    color: #aaaaaa;
                }
            }
        }
    }
</style>