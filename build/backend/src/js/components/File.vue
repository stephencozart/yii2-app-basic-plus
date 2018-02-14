<template>
    <div :class="'file-list-file' + (active ? ' active':'')" @click="$emit('click')">
        <div class="file-list-thumbnail">
            <font-awesome-icon v-if="icon" :icon="icon" size="lg"></font-awesome-icon>
        </div>
        <div class="file-list-description">
            <div class="file-list-name">
                {{ file_name }}
            </div>
            <div class="file-list-meta">
                <span>
                    Modified {{ updated_at }}
                </span>
                <span>
                    {{ file_size | humanizeFileSize }}
                </span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'file_name',
            'mime_type',
            'file_size',
            'name',
            'id',
            'width',
            'height',
            'url',
            'updated_at',
            'active'
        ],
        computed: {
            icon() {
                return 'file';
            }
        },
        filters: {
            humanizeFileSize(bytes, decimals) {
                if (bytes === 0) {
                    return '0 Bytes';
                }
                let k = 1024,
                    dm = decimals || 0,
                    sizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                    i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        }
    }
</script>
<style lang="scss">
    .file-list-file {
        display: flex;
        align-items: center;
        background-color: #f9f9f9;
        padding: .5rem 1.5em;
        &:nth-child(odd) {
            background-color: #ffffff;
        }

        .file-list-thumbnail {
            width: 1.7rem;
            margin-right: 1rem;
            text-align: center;
        }
        .file-list-meta {
            font-size: .8rem;
        }
        .file-list-name {
            font-weight: 500;
        }
    }
</style>