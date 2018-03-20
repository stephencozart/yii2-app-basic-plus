<template>
    <div class="file-browser">
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">File Browser</h5>
                        <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">                        
                        <div v-if="items && items.length > 0" class="file-browser-items">
                            <media-thumbnail @click="selectFile(item)" v-for="item in items" :key="'thumbnail-'+item.id" v-bind="item">
                                <div class="add-overlay">
                                    <div class="add-overlay-icon">                                    
                                        <font-awesome-icon icon="plus" prefix="far"></font-awesome-icon>
                                    </div>
                                </div>
                            </media-thumbnail>
                        </div>
                        <div v-else>
                            <div v-if="didRequestItems" class="empty-stage">
                                <div class="icon">
                                    <font-awesome-icon icon="info" prefix="far"></font-awesome-icon>
                                </div>
                                <div class="empty-stage-primary">
                                    there is nothing to see here
                                </div>
                                <div class="empty-stage-secondary">
                                    you have not uploaded any files yet
                                </div>
                            </div>
                            <div v-else class="empty-stage">
                                <div class="empty-stage-primary">
                                    Fetching content, please wait...
                                </div>
                                <div class="empty-stage-secondary">
                                    this shouldn't take to long
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button @click="$refs.fileInput.click()" class="btn btn-outline-primary mr-auto">
                            <font-awesome-icon icon="upload" prefix="far"></font-awesome-icon>
                            <input multiple :accept="accept" type="file" ref="fileInput" @change="handleFile" class="incognito-file-input" />
                        </button>
                        <button class="btn btn-outline-secondary" v-if="links.prev" @click="get(links.prev.href)">
                            <font-awesome-icon icon="angle-left" prefix="far"></font-awesome-icon>
                        </button>
                        <button class="btn btn-outline-secondary" v-if="links.next" @click="get(links.next.href)">
                            <font-awesome-icon icon="angle-right" prefix="far"></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import MediaThumbnail from './MediaThumbnail.vue';

export default {
    name: 'file-browser',
    props: {
        scope: {
            type: String,
            default: 'image'
        }
    },
    components: {
        MediaThumbnail
    },
    mounted() {
        this.get('/admin/media-library?per-page=8&type='+this.scope);
    },
    computed: {
        accept() {
            if (this.scope === 'image') {
                return 'image/*'
            }
            if (this.scope === 'video') {
                return 'video/*'
            }
            if (this.scope === 'audio') {
                return 'audio/*'
            }
            return null;
        }
        
    },
    data() {
        return {
            items: [],
            links: {
                prev: null,
                next: null
            },
            meta: null,
            didRequestItems: false,
            uploader: {
                files: []
            }
        }
    },
    methods: {
        get(url) {
            this.$http.get(url.convertUrlToRelative()).then((response) => {
                this.items = response.data.items;      
                this.links = response.data._links;
                this.meta = response.data._meta;  
                this.didRequestItems = true;
            });  
        },
        selectFile(file) {
            this.$emit('selectFile', file);
        },
        handleFile() {
            let input = this.$refs.fileInput;
            this.uploader.files = [];
            this.items = [];
            _.each(input.files, (file, i) => {

                let formData = new FormData();
                formData.append('file', file);

                this.uploader.files.push({
                    fileName: file.name,
                    fileSize: file.size,
                    progress: 0
                });

                let config = {
                    onUploadProgress: (progressEvent) => {
                        this.uploader.files[i].progress = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    },
                    onLoad: () => {
                        this.uploader.files[i].progress = 100;
                    }
                };

                this.$http.post('/admin/media-library/upload', formData, config).then((response) => {
                    this.items.push(response.data);
                    input.value = '';
                }).catch((error) => {
                    this.uploader.files[i].error = error.response.statusText;
                    input.value = '';
                });
            });
        }
    }
}    
</script>
<style lang="scss">
    
    .incognito-file-input {
        position: absolute;
        top: 0;
        left: -99999px;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .empty-stage {
        text-align: center;
        opacity: .5;        
        padding: 5rem 1rem;
        margin: -1rem;
        .icon {
            font-size: 2rem;
            line-height: 1;
            margin: 0 auto;
            width: 5rem;
            height: 5rem;
            border: 1px solid #4d4d4d;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;     
            margin-bottom: 1rem;       
        }
        .empty-stage-primary {
            font-size: 1.5rem;
        }
    }
    .file-browser {
        .modal-body {
            background-color: #dbe4ec;
        }
        .modal-footer {
            min-height: 71px;
        }
    }
    .file-browser-items {
        display: flex;
        flex-wrap: wrap;
        .media-thumbnail {
            width: 175px;
            height: 175px;           
            flex-shrink: 0;
            padding-bottom: 175px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 1px 1px 8px 0 #999999;

            .add-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(255,255,255,.8);
                z-index: 20;
                display: none;    
                align-items: center;
                justify-content: center;   
                transition: opacity 250ms ease-in-out;
                transition-delay: 100ms;
                opacity: 0;

                .add-overlay-icon {
                    width: 55px;
                    height: 55px;
                    background: #3a2458;        
                    border-radius: 50px;
                    text-align: center;

                    display: flex;                    
                    align-items: center;
                    justify-content: center;
                    color: #ffffff;    
                    position: relative;
                    z-index: 21;

                }         
            }

            &:hover {
                .add-overlay {
                    display: flex;
                    opacity: 1;
                    cursor: pointer;
                }
            }

            .media-thumbnail-inner {
                width: 100%;
                height: 100%;                
                overflow: hidden;                                
            }
            .media-embed {
                max-width: 100%;
                img, video, audio, svg {
                    max-width: 100%;
                }
            }
            .filename {
                position: absolute;
                bottom: 0;
                background: rgba(255,255,255,.9);
                padding: .5rem;
                left: 0;
                right: 0;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                font-size: .7rem;
            }
        }
    }
</style>