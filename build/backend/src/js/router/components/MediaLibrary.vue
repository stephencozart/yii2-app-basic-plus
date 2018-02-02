<template>
    <div class="component file-manager">
        <div class="browser">
            <a>All Files</a>
            <a>Recent Activity</a>
            <a>Images</a>
            <a>Video</a>
            <a>Documents</a>
            <hr>
            <a>Products</a>
            <a>Blog</a>
        </div>
        <div class="contents">
            <div class="content-header">
                <div class="upload-button">
                    <button @click="chooseFile" class="btn btn-rounded">
                        <font-awesome-icon icon="upload"></font-awesome-icon> Upload Files
                    </button>
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
                <div class="media-thumbnails">
                    <media-thumbnail v-bind="mediaFile" :key="'media-' + mediaFile.id" v-for="mediaFile in media"></media-thumbnail>
                </div>
            </div>
            <div ref="scrollMarker"></div>

        </div>
    </div>
</template>
<script>
    import MediaThumbnail from '../../components/MediaThumbnail';

    export default {
        components: {
            MediaThumbnail
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
                meta: {}
            }
        },
        computed: {
            overlay() {
                return this.$store.state.overlay;
            },

        },
        mounted() {
            this.getMedia();
            document.body.onscroll = (event) => {
                let marker = this.$refs.scrollMarker;
                console.log(this.isScrolledIntoView(marker));
            };
        },
        methods: {
            isScrolledIntoView(elem) {
                let docViewTop = window.pageYOffset;
                let docViewBottom = docViewTop + window.outerHeight;

                let elemTop = elem.offsetTop;
                let elemBottom = elemTop + elem.offsetHeight;
                console.log(elemBottom, docViewBottom, elemTop, docViewTop);
                return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
            },
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
            getMedia() {
                this.$http.get('/admin/media-library').then((response) => {
                    this.media = response.data.items;
                    this.links = response.data._links;
                    this.meta = response.data._meta;
                }).catch((error) => {
                    this.$store.dispatch('errorNotification', error.response.statusText);
                });
            }
        }
    }
</script>
<style lang="scss">
    .file-manager {
        margin: -1.5rem -2rem;

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
            padding-top: .2rem;
            a {
                padding: .2rem 2rem;
                display: block;
            }
        }
        .contents {
            flex-basis: 0;
            flex-grow: 1;
            padding: 2rem;
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
            .media-thumbnails {
                margin-top: 1.5rem;
                display: flex;
                flex-wrap: wrap;
            }
        }



    }
</style>