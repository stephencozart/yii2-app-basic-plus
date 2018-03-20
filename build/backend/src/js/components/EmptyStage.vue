<template>
    <div class="empty-stage">
        <div v-if="heading" class="empty-stage-heading">
            {{ heading }}
        </div>
        <div v-if="content" class="empty-stage-content">
            {{ content }}
        </div>
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props: [
            'heading',
            'content'
        ]
    }
</script>
<style lang="scss">
    .empty-stage {
        padding: 4rem;
        display: flex;
        align-items: center;
        flex-direction: column;
        .empty-stage-heading {
            font-size: 1.8rem;
            line-height: 1.4;
            font-weight: 500;
            margin-bottom: 2rem;
        }
        .empty-stage-content {
            margin-bottom: 2rem;
        }
    }
</style>