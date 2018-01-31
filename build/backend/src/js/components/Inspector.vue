<template>
    <div class="inspector" v-if="inspect">
        <div class="inspector-label">
            {{ inspect.displayName }}
        </div>
        <div class="inspector-set layout">
            <div class="inspector-set-heading">
                Layout
            </div>
            <div class="inspector-set-body">
                <div class="inspector-set-display">
                    <select v-model="styles.display">
                        <option value="block">Block</option>
                        <option value="inline-block">Inline Block</option>
                        <option value="inline">Inline</option>
                        <option value="flex">Flex</option>
                        <option value="none">None</option>
                    </select>
                </div>
                <hr>
                <div class="inspector-set-top">
                    <input type="text" ref="paddingTop" v-model="styles.paddingTop" />
                </div>
                <div class="inspector-set-x">
                    <input type="text" ref="paddingLeft" v-model="styles.paddingLeft" />
                    <span>Padding</span>
                    <input type="text" ref="paddingRight" v-model="styles.paddingRight" />
                </div>
                <div class="inspector-set-bottom">
                    <input type="text" ref="paddingBottom" v-model="styles.paddingBottom"  />
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="inspector-form-group">
                            <label>Width</label>
                            <input v-model="styles.width" />
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="inspector-form-group">
                            <label>Height</label>
                            <input v-model="styles.height" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            styles() {
                return this.inspect.styles[this.deviceMode] ? this.inspect.styles[this.deviceMode] : {};
            },
            inspect() {
                return this.$store.state.inspect;
            },
            deviceMode() {
                return this.$store.state.deviceMode;
            }
        }
    }
</script>