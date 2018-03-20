<template>
    <div class="right-panel-wrapper">
        <div class="right-panel">
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        this.$store.commit('SHOW_OVERLAY');
    },
    data() {
        return {

        }
    }
}
</script>
<style lang="scss">
.right-panel-wrapper {
    
}
.right-panel {
    position: fixed;
    right: 0;
    top: 0;
    bottom: 0;
    width: 500px;
    max-width: 100%;
    box-shadow: 0 0 3px #dddddd;
    background-color: #ffffff;
    z-index: 11;    
    overflow-y: scroll;
}
</style>