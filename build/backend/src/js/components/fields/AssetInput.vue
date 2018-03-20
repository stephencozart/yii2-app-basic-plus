<template>
    <div class="asset-field">
        <label>{{ label }}</label>
        <div class="asset-field-content">
            
                <draggable :options="{draggable:'.asset-field-selection', clone: false}" class="asset-field-selections" v-model="valueInternal" @click.stop>
                    <div v-for="(asset, assetIdx) in valueInternal" class="asset-field-selection">
                        <img :src="asset.url" />
                        <div class="remove-overlay">
                            <button @click="removeAsset(assetIdx)" class="btn btn-light">
                                <font-awesome-icon icon="times" prefix="far"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                    <button @click="$store.commit('SHOW_OVERLAY')" class="btn btn-light">
                        <font-awesome-icon size="2x" icon="plus" prefix="far"></font-awesome-icon>
                    </button>
                </draggable>
            
            

        </div>
        <file-browser @selectFile="selectFile" @close="$store.commit('HIDE_OVERLAY')" v-if="overlay"></file-browser>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins';
    import FileBrowser from '../FileBrowser.vue';
    import draggable from 'vuedraggable'
    
    export default {
        name: 'asset-input',
        mixins: [BaseFieldMixin],
        components: {
            FileBrowser,
            draggable
        },
        data() {
            let value = this.value && this.value.length > 0 ? JSON.parse(this.value) : [];
            return {
                showFileBrowser: false,
                valueInternal: value
            }
        },
        computed: {
            overlay() {
                return this.$store.state.overlay;
            }
        },
        methods: {
            selectFile(file) {
                this.valueInternal.push(file);
            },
            removeAsset(assetIdx) {
                this.valueInternal.splice(assetIdx, 1);
            }
        },
        watch: {
            valueInternal(values) {
                this.$emit('input', JSON.stringify(values));
            }
        }
    }
     
</script>
<style lang="scss">
    .asset-field-selections {
        display: flex;
        flex-wrap: wrap;
        >.btn {
            width: 90px;
            height: 90px;
            border-radius: 5px;
            border: 3px dashed #C8CCD4;
            color: #C8CCD4;
        }
        .asset-field-selection {
            width: 90px;
            height: 90px;
            overflow: hidden;
            position: relative;
            border-radius: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
            box-shadow: 2px 2px 1px 0 #aaaaaa;
            &:hover {
                .remove-overlay {
                    display: flex;
                }
            }
            
            img {
                height: 100%;
                width: auto;
            }

            .remove-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(100,100,100,.7);                
                justify-content: center;
                align-items: center;
                display: none;
                .btn {
                    border-radius: 50px;
                    opacity: .8;
                }
            }
        }
    }
</style>