import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default function() {
    return new Vuex.Store({
        state: {
            user: {},
            notifications: [
                /*{
                    type: 'success',
                    message: 'Good job what you did worked!',
                    icon: 'check-circle'
                },
                {
                    type: 'error',
                    message: 'Oh boy,  that did not go very will did it?',
                    icon: 'exclamation-triangle'
                }*/
            ],
            roles: [],
            inspect: null,
            overlay: false,
        },
        mutations: {
            USER(state, payload) {
                state.user = payload;
            },
            ROLES(state, payload) {
                state.roles = payload;
            },
            SHOW_OVERLAY(state) {
                state.overlay = true;
            },
            HIDE_OVERLAY(state) {
                state.overlay = false;
            }
        },
        actions: {
            pushErrorNotification({commit, state}, message) {
                state.notifications.push({
                    type: 'error',
                    message: message,
                    icon: 'exclamation-triangle'
                });
            },
            pushSuccessNotification({commit, state}, message) {
                state.notifications.push({
                    type: 'success',
                    message: message,
                    icon: 'check-circle'
                })
            },
            removeNotification({commit, state}, index) {
                state.notifications.splice(index, 1);
            }
        }
    });
}