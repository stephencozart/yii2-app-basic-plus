<template>
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" aria-label="Close" @click="$emit('cancel')">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer" v-if="confirm || close">
                    <button v-if="close" @click="$emit('cancel')" type="button" class="btn btn-secondary">{{ close }}</button>
                    <button v-if="confirm" @click="$emit('confirm')" type="button" class="btn btn-primary">{{ confirm }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'title',
            'confirm',
            'close'
        ]
    }
</script>