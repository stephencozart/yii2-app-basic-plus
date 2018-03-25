<template>

    <div :class="'revision-icon ' + primaryStatus">
        <font-awesome-icon :icon="primaryStatus === 'published' ? 'eye' : 'pencil-alt'" prefix="far"></font-awesome-icon>
        <div v-if="hasDraft" class="sub-status">
            <div class="revision-icon draft">
                <font-awesome-icon icon="pencil-alt" prefix="far"></font-awesome-icon>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: [
            'item'
        ],
        data() {
            return {

            }
        },
        computed: {
            status() {
                return this.item.status;
            },
            primaryStatus() {
                return this.item.published && this.item.published.id ? 'published' : 'draft';
            },
            hasDraft()
            {
                return this.item.status === 'draft' && this.primaryStatus === 'published';
            }
        }
    }
</script>
<style lang="scss">
    .revision-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50px;
        margin-right: 1rem;
        position: relative;

        &.published {
            background-color: #48d28e;
            color: #ffffff;
        }
        &.draft {
            background-color: #f9b74f;
            color: #ffffff;
        }
        .sub-status {
            position: absolute;
            top: -6px;
            left: 26px;
            font-size: 10px;
            .revision-icon {
                width: 22px;
                height: 22px;
                box-shadow: 0 0 0 1px #ffffff;
            }
        }
    }

</style>