<template>
    <a class="media-thumbnail" @click="$emit('click')" target="_blank">
        <div class="media-thumbnail-inner">
            <div class="media-embed">
                <img :src="url" v-if="type === 'img'" />
                <video :src="url" v-if="type === 'video'" controls></video>
                <audio :src="url" v-if="type === 'audio'" controls></audio>
                <font-awesome-icon v-if="type === 'file'" icon="file" size="5x"></font-awesome-icon>
            </div>
            <div class="filename">
                {{ file_name }}
            </div>            
        </div>
        <slot></slot>
    </a>
</template>
<script>
    import MediaEmbed from './MediaEmbed.vue';
    export default {
        components: {
            MediaEmbed
        },
        props: [
            'file_name',
            'mime_type',
            'file_size',
            'name',
            'id',
            'width',
            'height',
            'url'
        ],
        computed: {
            icon() {
                return 'file';
            },
            type() {
                if (this.mime_type.substring(0, 5) === 'image') {
                    return 'img'
                }
                if (this.mime_type.substring(0, 5) === 'video') {
                    return 'video'
                }
                if (this.mime_type.substring(0, 5) === 'audio') {
                    return 'audio'
                }
                console.log(this.mime_type.substring(0, 5));

                return 'file';
            }
        }
    }
</script>
<style lang="scss">
    .media-thumbnail {
        position: relative;
        width: 18%;
        background-color: #fefefe;
        border-radius: 2px;
        margin: 1%;
        box-shadow: 0 0 2px 0 #ddd;
        display: block;

        &:after {
            content: '';
            display: block;
            padding-bottom: 100%;
        }
        .media-thumbnail-inner {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }
    }
</style>