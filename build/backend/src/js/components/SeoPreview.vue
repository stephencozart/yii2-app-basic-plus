<template>
    <div class="seo-preview">
        <div class="seo-preview-title">
            {{ title }}
        </div>
        <div class="seo-preview-url">
            {{ url }}
        </div>
        <div class="seo-preview-description">
            {{ description }}
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'title',
            'url',
            'description'
        ]
    }
</script>
<style lang="scss">
    .seo-preview-title {
        min-height: 21px;
        display: block;
        font-size: 18px;
        color: #1a0dab;
        line-height: 21px;
        margin-bottom: 2px;
        overflow-wrap: break-word;
        word-wrap: break-word;
    }
    .seo-preview-url {
        display: block;
        word-wrap: break-word;
        color: #006621;
        font-size: 13px;
        line-height: 16px;
        margin-bottom: 2px;
    }
    .seo-preview-description {
        display: block;
        color: #545454;
        line-height: 18px;
        font-size: 13px;
    }
</style>