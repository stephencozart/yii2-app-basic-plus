<template>
    <div class="media-thumbnail">
        <div class="media-thumbnail-inner">
            <div class="icon">
                <font-awesome-icon :icon="icon" size="3x"></font-awesome-icon>
            </div>
            <div class="filename">
                {{ file_name }}
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
            'height'
        ],
        computed: {
            icon() {
                return 'file';
            }
        }
    }
</script>
<style lang="scss">
    .media-thumbnail {
        position: relative;
        width: 20%;

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