<template>
    <div class="component users">
        <header class="component-header">
            <div class="component-header-main-group">
                <h1 class="component-title">Users</h1>
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