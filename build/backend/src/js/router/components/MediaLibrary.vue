<template>
    <div class="component file-manager">
        <div class="browser">
            <router-link to="/media-library">
                <font-awesome-icon size="lg" :fixed-width="true" icon="bars"></font-awesome-icon>
                All Files
            </router-link>
            <router-link to="/media-library/recent">
                <font-awesome-icon size="lg" :fixed-width="true" icon="clock"></font-awesome-icon>
                Recent Activity
            </router-link>
            <router-link to="/media-library/images">
                <font-awesome-icon size="lg" :fixed-width="true" icon="image"></font-awesome-icon>
                Images
            </router-link>
            <router-link to="/media-library/videos">
                <font-awesome-icon size="lg" :fixed-width="true" icon="video"></font-awesome-icon>
                Video
            </router-link>
            <router-link to="/media-library/audio">
                <font-awesome-icon size="lg" :fixed-width="true" icon="headphones"></font-awesome-icon>
                Audio
            </router-link>
            <router-link to="/media-library/documents">
                <font-awesome-icon size="lg" :fixed-width="true" icon="file"></font-awesome-icon>
                Documents
            </router-link>
        </div>
        <div class="contents">
            <div style="position: absolute;">{{ }}</div>
            <div class="content-header">
                <div class="upload-button">
                    <a @click="chooseFile" class="file-upload-button">
                        <font-awesome-icon icon="upload"></font-awesome-icon> Upload Files
                    </a>
                    <input ref="fileInput" type="file" multiple @change="uploadFile" />
                </div>
                <div v-if="overlay && (uploader.files && uploader.files.length > 0)" class="upload-progress-wrapper">
                    <div v-for="file in uploader.files" class="upload-progress-container">
                        <div class="icon">
                            <font-awesome-icon :icon="file.progress === 100 ? 'check-circle' : 'upload'"></font-awesome-icon>
                        </div>
                        <div class="file-info">
                            <div class="file-name">
                                {{ file.fileName }} <span>({{ file.fileSize }})</span>
                            </div>
                            <div class="upload-progress">
                                <div class="upload-progress-bar" v-bind:style="{ width: file.progress + '%'}"></div>
                            </div>
                            <div v-if="file.error" class="upload-error text-danger">
                                {{ file.error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="file-list">
                    <file
                        @click="preview = mediaFile"
                        v-bind="mediaFile"
                        :active="preview && preview.id === mediaFile.id"
                        :key="'file-' + mediaFile.id"
                        v-for="mediaFile in media">
                    </file>
                </div>
                <transition
                        name="app-transition"
                        enter-active-class="animated slideInRight"
                        leave-active-class="animated slideOutRight"
                        appear
                >
                    <div class="preview-panel" v-if="preview">
                        <a class="preview-panel-close" @click="preview = null">
                            <font-awesome-icon icon="times"></font-awesome-icon>
                            close
                        </a>
                        <div class="preview-panel-name">
                            {{ preview.file_name }}
                        </div>
                        <div class="preview-panel-preview">
                            <media-embed v-bind="preview"></media-embed>
                            <a class="preview-panel-download-button" :href="preview.url" target="_blank">
                                <font-awesome-icon icon="download"></font-awesome-icon> Download
                            </a>
                        </div>
                        <hr>
                        <div class="preview-meta-data row">
                            <div class="col">
                                <div class="text-muted">
                                    Size
                                </div>
                                <div>
                                    {{ preview.file_size | humanizeFileSize(1) }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-muted">
                                    Dimensions
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>

            </div>
            <div class="component-footer" v-if="next">
                <button @click="getMedia(next)" class="btn btn-outline-primary btn-block btn-lg">Load More</button>
            </div>
        </div>

    </div>
</template>
<script>
    import MediaThumbnail from '../../components/MediaThumbnail';
    import Pager from '../../components/Pager';
    import File from '../../components/File';
    import MediaEmbed from '../../components/MediaEmbed';

    export default {
        components: {
            MediaThumbnail,
            Pager,
            File,
            MediaEmbed
        },
        props: [
            'icon'
        ],
        data() {
            return {
                uploader: {
                    files: [

                    ],
                },
                media: [],
                links: {},
                meta: {},
                preview: null
            }
        },
        watch: {
            '$route': function() {
                this.media = [];
                this.getMedia();
            }
        },
        computed: {
            next() {
                if (this.links.next) {
                    let pos = this.nthIndex(this.links.next.href, '/', 3);
                    return this.links.next.href.substring(pos);
                }
                return '';
            },
            overlay() {
                return this.$store.state.overlay;
            },
            mediaUrl() {
                let url = '/admin/media-library';

                if (this.$route.params.type) {
                    url += '?type='+this.$route.params.type;
                }

                return url;
            }
        },
        mounted() {
            this.getMedia();
        },
        methods: {
            uploadFile(event) {
                this.uploader.files = [];

                let files = event.target.files;

                _.each(files, (file, i) => {

                    let formData = new FormData();
                    formData.append('file', file);

                    this.uploader.files.push({
                        fileName: file.name,
                        fileSize: file.size,
                        progress: 0
                    });

                    let config = {
                        onUploadProgress: (progressEvent, foo) => {
                            this.uploader.files[i].progress = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        },
                        onLoad: () => {
                            this.uploader.files[i].progress = 100;
                        }
                    };

                    this.$http.post('/admin/media-library/upload', formData, config).then((response) => {
                        event.target.value = '';
                    }).catch((error) => {
                        this.uploader.files[i].error = error.response.statusText;
                        event.target.value = '';
                    });
                });

                this.$store.commit('SHOW_OVERLAY');

            },
            chooseFile() {
                this.$refs.fileInput.click();
            },
            getMedia(url) {
                let u = url ? url : this.mediaUrl;
                this.$http.get(u).then((response) => {
                    this.media = this.media.concat(response.data.items);
                    this.links = response.data._links;
                    this.meta = response.data._meta;
                }).catch((error) => {
                    this.$store.dispatch('errorNotification', error.response.statusText);
                });
            },
            nthIndex(str, pat, n) {
                let L = str.length, i= -1;
                while(n-- && i++<L) {
                    i= str.indexOf(pat, i);
                    if (i < 0) break;
                }
                return i;
            }
        }
    }
</script>
<style lang="scss">
    .file-manager {
        margin: -1.5rem -2rem;
        position: relative;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        min-height: 100%;

        @media(min-width: 768px) {
            flex-direction: row;
            min-height: calc(100vh - 60px);
        }

        @media(min-width: 1024px) {
            margin: -2rem;
        }

        .preview-panel {
            animation-duration: 250ms;
            width: 275px;
            background: #f9f9f9;
            min-height: calc(100vh - 60px);
            box-shadow: 0 0 3px 0 #cccccc;
            position: relative;
            padding: 1.7rem 1.2rem 1.2rem 1.2rem;

            .preview-panel-close {
                opacity: .5;
                position: absolute;
                left: 1.2rem;
                top: 5px;
                cursor: pointer;
            }

            .preview-panel-name {
                font-weight: 500;
                font-size: 1.2rem;
                margin-bottom: 1rem;
                word-break: break-all;
                line-height: normal;
                text-overflow: ellipsis;
            }

            .preview-panel-preview {
                img, video, audio {
                    max-width: 100%;
                }
                text-align: center;
                .media-embed {
                    box-shadow: 0 0 15px 2px #aaaaaa;
                    display: inline-block;
                    svg {
                        margin: 1.2rem;
                    }
                    margin-bottom: 1.2rem;
                }

            }

            .preview-panel-download-button {
                cursor: pointer;
                display: block;
                text-align: center;
                color: inherit;
                text-decoration: none;
                svg {
                    opacity: .5;
                }
                &:hover {
                    svg {
                        opacity: .8;
                    }
                }
            }
        }

        .file-upload-button {
            display: block;
            padding: 1.25rem 1.5rem;
            cursor: pointer;
        }

        .upload-progress-wrapper {
            position: fixed;
            width: 300px;
            z-index: 3;
            left: 50%;
            margin-left: -150px;
            max-height: 90%;
            border-radius: 10px;

            .upload-progress-container {
                flex: 0 1 100%;
                display: flex;
                align-items: center;
                background: #ffffff;
                padding: 15px 15px 15px 0;
                border-bottom: 1px solid transparent;
                margin-bottom: 1px;
                &:first-child {
                    border-top-right-radius: 10px;
                    border-top-left-radius: 10px;
                }
                &:last-child {
                    border-bottom-right-radius: 10px;
                    border-bottom-left-radius: 10px;
                }
                .icon {
                    flex: 0 0 50px;
                    text-align: center;
                }
                .file-info {
                    flex: 0 1 100%;
                    .file-name {
                        margin-bottom: 5px;
                    }
                    .upload-progress {
                        .upload-progress-bar {
                            width: 0;
                            height: 3px !important;
                            background-color: #45807a;
                            transition: 250ms ease-in-out;
                        }
                    }
                }

            }
        }

        .browser {
            background-color: #eeeeee;
            flex: 0 0 260px;
            max-width: 260px;
            a {
                padding: .5rem 2rem;
                display: block;
                text-decoration: none;
                color: inherit;
                cursor: pointer;
                svg {
                    opacity: .5;
                }
                &.router-link-exact-active {
                    background-color: #cccccc;
                    svg {
                        opacity: .8;
                    }
                }
                &:hover {
                    svg {
                        opacity: .8;
                    }
                }
            }
        }
        .contents {
            flex-basis: 0;
            flex-grow: 1;
            padding: 0;
            .content-header {
                display: flex;

                .upload-button {
                    margin-right: 15px;
                    input[type="file"] {
                        position: absolute;
                        opacity: 0;
                        height: 0;
                        width: 0;
                    }
                }


            }
            .content-body {
                display: flex;
                .file-list {
                    flex-basis: 0;
                    flex-grow: 1;
                }
            }
            .media-thumbnails {
                margin-top: 1.5rem;
                display: flex;
                flex-wrap: wrap;
            }
        }





    }
</style>