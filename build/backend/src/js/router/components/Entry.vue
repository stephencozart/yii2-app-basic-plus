<template>
    <div class="component entry">
        <div class="component-bread-crumbs">
            <router-link to="/entries"><font-awesome-icon icon="angle-left"></font-awesome-icon> Entries</router-link>
        </div>
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">
                    {{ componentTitle }} <span v-if="entryType && entryType.name"> in <strong>{{ this.entryType.name }}</strong></span>
                </h1>
                <div class="component-actions">
                    
                </div>
            </div>
            <div class="component-header-alt-group">
                <button @click="save" v-if="entryState === 'dirty'" class="btn btn-secondary">
                    <font-awesome-icon icon="save" prefix="far"></font-awesome-icon>
                    Save
                </button>
                <button @click="publish" v-if="entryState === 'draft'" class="btn btn-primary" :disabled="!touched">
                    <font-awesome-icon icon="arrow-up" prefix="far"></font-awesome-icon>
                    Publish
                </button>
                <button @click="unPublish" v-if="entryState === 'published'" class="btn btn-primary">
                    <font-awesome-icon icon="arrow-down" prefix="far"></font-awesome-icon>
                    Unpublish
                </button>
            </div>
        </header>
        <div class="component-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <text-input
                                label="Title"
                                v-model="model.title"
                                required="true"
                                v-validate="'required'"
                                name="Title"
                                @blur="createHandle"
                                :error="errors.first('Title')">
                            </text-input>

                            <text-input
                                    label="Handle"
                                    v-model="model.handle"
                                    v-validate="'required'"
                                    name="Handle"
                                    required="true"
                                    :error="errors.first('Handle')">
                            </text-input>

                            <rich-text
                                    v-model="model.content"
                                    label="Content">
                            </rich-text>

                            <div class="row entry-fields" v-if="entryType && model.data">
                                <div :class="field.layout" v-for="field in entryType.fieldRegistry">
                                    <component
                                            v-bind:is="field.field_type_handle"
                                            v-bind="field"
                                            v-validate="createValidationRules(field)"
                                            v-model="model.data[field.handle]"
                                            :error="errors.first(field.handle)"
                                            :name="field.handle"
                                            :key="'field-'+field.handle">
                                    </component>
                                </div>

                            </div>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6>Revisions</h6>
                            <div class="revision-list">
                                <div @click="toRevision(revision)" v-for="revision in model.revisions" :class="'revision' + (model.id === revision.id ? ' current':'') + ' ' + revision.status">
                                    <div class="revision-icon">
                                        <font-awesome-icon :icon="revision.status === 'published' ? 'eye' : 'pencil-alt'" prefix="far"></font-awesome-icon>
                                    </div>
                                    <div class="revision-details">
                                        {{ revision.updated_at | humanizeDate }}<br>
                                        <small>{{ revision.status }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <flat-pickr :config="datePickerConfig" v-model="model.publish_at"></flat-pickr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import SeoPreview from '../../components/SeoPreview'
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    export default {
        components: {
            SeoPreview,
            flatPickr
        },
        computed: {
            componentTitle() {
                return this.model.id ? this.model.title : 'New Entry'
            },
            metaTitle() {
                return this.model.meta_title.length > 0 ? this.model.meta_title : this.model.name;
            },
            url() {
                let parts =  [window.location.origin, this.model.handle];
                return parts.join('/');
            },
            entryState() {
                if (this.dirty === null) {
                    return '';
                }
                if (this.dirty) {
                    return 'dirty';
                }

                return this.model.status;
            }
        },
        created() {
            this.loadModel()
        },
        watch: {
            model: {
                handler(value) {
                    this.dirty = true;
                    this.touched = true;                
                },
                deep: true
            },
            '$route'() {
                this.loadModel()
            }
        },
        methods: {
            loadModel() {
                if (this.$route.params.entryId) {
                    this.$http.get('/admin/entry/'+this.$route.params.entryId).then((response) => {
                        this.model = response.data;
                        this.loadEntryType();
                    });
                } else {
                    this.loadEntryType();
                }
            },
            loadEntryType() {
                return this.$http.get('/admin/entry-types/'+this.$route.params.type).then((response) => {
                    this.entryType = response.data;
                    let data = {};
                    let modelData = this.model.data;
                    _.each(this.entryType.fieldRegistry, (field) => {
                        data[field.handle] = field.default_value ? field.default_value : ''
                    });
                    _.each(modelData,  (value, key) => {
                        if (data.hasOwnProperty(key)) {
                            data[key] = value;
                        }
                    });
                    this.model.data = data;
                    this.model.entry_type_handle = this.entryType.handle;
                    this.model.entry_type_id = this.entryType.id;
                    this.$nextTick(() => {
                        this.dirty = false;
                        if (this.$route.name === 'new-entry') {
                            this.touched = false;
                        }

                    });                    
                })
            },
            toRevision(revision) {
                if (revision.id === this.model.id) {
                    return;
                }

                this.$router.push({
                    name: 'edit-entry',
                    params: {
                        entryId: revision.id,
                        type: revision.entry_type_id
                    }
                })
            },
            createHandle(value) {
                this.model.handle = this.model.handle.length === 0 ? value.slugify() : this.model.handle;
            },
            createValidationRules(field) {
                let rules = [];
                if (field.required) {
                    rules.push('required')
                }
                let rule = rules.join('|');
                return rule;
            },
            save(status) {
                let model = JSON.parse(JSON.stringify(this.model));
                model.status = status ? status : 'draft';
                this.$http.post('/admin/entries', model).then((response) => {
                    this.$nextTick(() => {
                        this.dirty = false;
                        if (this.$route.name === 'new-entry') {
                            this.touched = false;
                        }

                    });
                    this.$router.push({
                        name: 'edit-entry',
                        params: {
                            entryId: response.data.id,
                            type: response.data.entry_type_id
                        }
                    })
                });
            },
            publish() {
                this.$http.post('/admin/entries/publish/'+this.model.id).then((response) => {
                    this.loadModel();
                    this.$nextTick(() => {
                        this.dirty = false;
                    });
                });
            },
            unPublish() {
                this.$http.post('/admin/entries/un-publish/'+this.model.id).then((response) => {
                    this.loadModel();
                    this.$nextTick(() => {
                        this.dirty = false;
                    });
                });

            }
        },
        data() {
            return {
                entryType: null,
                dirty: null,
                touched: false,
                model: {
                    entry_type_id: null,
                    entry_type_handle: '',
                    title: '',
                    handle: '',                
                    content: '',
                    meta_title: '',
                    meta_description: '',
                    publish_at: '',
                    data: null,
                    status: 'draft'
                },
                datePickerConfig: {
                    altFormat: 'F J, Y h:i K',
                    altInput: true,
                    enableTime: true
                }
            }
        }
    }
</script>
<style lang="scss">
    .revision-list {
        .revision {
            box-shadow: 0 0 0 1px rgba(217,225,234,0.47), 0 2px 2px 0 rgba(144,158,190,0.21);
            border-radius: 3px;
            background: #ffffff;
            line-height: 1;
            font-size: .85rem;
            padding: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            +.revision {
                margin-top: 1rem;
            }
            &.current {
                background: #f5f6f8;
                box-shadow: none;
                cursor: inherit;
            }

            .revision-icon {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 40px;
                height: 40px;
                border-radius: 50px;
                margin-right: 1rem;
            }
            &.published {
                .revision-icon {
                    background-color: #48d28e;
                    color: #ffffff;
                }
            }
            &.draft {
                .revision-icon {
                    background-color: #f9b74f;
                    color: #ffffff;
                }
            }
        }
    }
</style>