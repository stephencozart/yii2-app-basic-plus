<template>
    <div class="element section">
        <span>{{ name }}</span>
    </div>
</template>
<script>
    export default {
        props: [
            'name',
            'type'
        ],
        mounted() {
            this.$el.draggable = true;
            this.$el.ondragstart = (event) => {
                event.dataTransfer.setData('text/plain', this.type);
            };
        }
    }
</script>