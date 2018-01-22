<template>
    <div class="component home">
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">Dashboard</h1>
                <div class="component-actions"></div>
            </div>
            <div class="component-header-alt-group">

            </div>
        </header>
        <div class="component-body">
            {{ $route.name }}
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {}
        }
    }
</script>