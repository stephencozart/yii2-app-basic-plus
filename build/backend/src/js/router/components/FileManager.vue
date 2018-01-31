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
            {{ $route.name }}
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'icon'
        ],
        data() {
            return {}
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
        }
    }
</style>