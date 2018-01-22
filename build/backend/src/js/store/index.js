import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default function() {
    return new Vuex.Store({
        state: {
            user: {}
        },
        mutations: {
            USER(state, payload) {
                state.user = payload;
            }
        }
    });
}