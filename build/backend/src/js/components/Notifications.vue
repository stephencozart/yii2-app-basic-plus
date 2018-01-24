<template>
    <div class="notification-center">
        <transition-group name="list" tag="div" enter-active-class="animated bounceInRight"
                          leave-active-class="animated bounceOutRight">
        <div :key="'notification-'+index" @click="dismiss(index)" :class="'notification '+notification.type" v-for="(notification, index) in notifications">
            <div class="icon">
                <font-awesome-icon :icon="notification.icon"></font-awesome-icon>
            </div>
            <div class="message">
                {{ notification.message }}
            </div>
            <div class="close">
                <font-awesome-icon icon="times-circle"></font-awesome-icon>
            </div>
        </div>
        </transition-group>
    </div>
</template>
<script>
    export default {
        name: 'notifications',
        computed: {
            notifications() {
                return this.$store.state.notifications;
            }
        },
        methods: {
            dismiss(index) {
                this.$store.dispatch('removeNotification', index);
            }
        }
    }
</script>