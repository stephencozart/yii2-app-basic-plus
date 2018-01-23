<template>
    <div class="result-pager">
        <button :disabled="!links.previous" class="btn" @click="$emit('previous', links.previous)">
            <font-awesome-icon icon="angle-left"></font-awesome-icon>
        </button>
        <button :disabled="!links.next" class="btn" @click="$emit('next', links.next)">
            <font-awesome-icon icon="angle-right"></font-awesome-icon>
        </button>
    </div>
</template>
<script>
    export default {
        props: [
            'links'
        ]
    }
</script>