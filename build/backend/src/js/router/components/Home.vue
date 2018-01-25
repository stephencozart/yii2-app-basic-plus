<template>
    <div class="component home">
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">
                    <font-awesome-icon :icon="icon"></font-awesome-icon>
                    Dashboard
                </h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">

            </div>
        </header>
        <div class="component-plugins">
            <div v-for="plugin in mainPlugins">
                <component v-bind:is="plugin.name"></component>
            </div>
        </div>
        <div class="component-body">

        </div>

    </div>
</template>
<script>
    export default {
        props: [
            'icon'
        ],
        data() {
            return {}
        },
        computed: {
            mainPlugins() {
                return _.filter(document.vuePlugins, (plugin) => {
                    return plugin.namespace === 'dashboard' && plugin.region === 'main';
                });
            }
        }
    }
</script>