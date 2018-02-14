<template>
    <div class="result-pager">
        <button :disabled="!links.previous" class="btn" @click="$emit('previous', previous)">
            <font-awesome-icon icon="angle-left"></font-awesome-icon>
        </button>
        <button :disabled="!links.next" class="btn" @click="$emit('next', next)">
            <font-awesome-icon icon="angle-right"></font-awesome-icon>
        </button>
    </div>
</template>
<script>
    export default {
        props: [
            'links'
        ],
        computed: {
            next() {
                let pos = this.nthIndex(this.links.next.href, '/', 3);
                return this.links.next.href.substring(pos);
            },
            previous() {
                let pos = this.nthIndex(this.links.previous.href, '/', 3);
                return this.links.previous.href.substring(pos);
            }
        },
        methods: {
            nthIndex(str, pat, n) {
                var L= str.length, i= -1;
                while(n-- && i++<L){
                    i= str.indexOf(pat, i);
                    if (i < 0) break;
                }
                return i;
            }
        }
    }
</script>