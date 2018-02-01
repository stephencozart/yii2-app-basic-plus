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
                    <input ref="fileInput" type="file" @change="uploadFile" />
                </div>
                <div v-if="uploader.show" class="upload-progress-container">
                    <div class="icon">
                        <font-awesome-icon :icon="uploaderIcon"></font-awesome-icon>
                    </div>
                    <div class="file-info">
                        <div class="file-name">
                            {{ uploader.fileName }} <span>({{ uploader.fileSize }})</span>
                        </div>
                        <div class="upload-progress">
                            <div class="upload-progress-bar" v-bind:style="uploadProgressStyle"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'icon'
        ],
        data() {
            return {
                uploader: {
                    show: false,
                    fileName: '',
                    fileSize: 0,
                    progress: 0
                }
            }
        },
        computed: {
            uploaderIcon() {
                return this.uploader.progress === 100 ? 'check-circle' : 'upload';
            },
            uploadProgressStyle() {
                return {
                    width: this.uploader.progress + '%'
                }
            }
        },
        methods: {
            uploadFile(event) {

                let formData = new FormData();

                let files = event.target.files;
                console.log(files);
                _.each(files, (file) => {

                });

                formData.append('files[]', files[0]);

                let config = {
                    onUploadProgress: (progressEvent) => {
                        this.uploader.progress = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    },
                    onLoad: () => {
                        this.uploader.progress = 100;
                    }
                };

                this.uploader.fileName = files[0].name;
                this.uploader.fileSize = files[0].size;
                this.uploader.show = true;

                this.$http.post('/admin/file-manager/upload', formData, config).then((response) => {

                }).catch((error) => {

                });
            },
            chooseFile() {
                this.$refs.fileInput.click();
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

                .upload-progress-container {
                    flex: 0 1 100%;
                    display: flex;
                    align-items: center;
                    background: #ffffff;
                    padding-right: 15px;
                    border-radius: 50px;
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
        }



    }
</style>