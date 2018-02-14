<template>
    <div class="media-embed">
        <img :src="url" v-if="type === 'img'" />
        <video :src="url" v-if="type === 'video'" controls></video>
        <audio :src="url" v-if="type === 'audio'" controls></audio>
        <font-awesome-icon v-if="type === 'file'" icon="file" size="5x"></font-awesome-icon>
    </div>
</template>
<script>
    export default {
        props: [
            'url',
            'file_name',
            'mime_type'
        ],
        computed: {
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