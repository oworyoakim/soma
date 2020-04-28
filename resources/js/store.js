import Vue from 'vue';
import Vuex from 'vuex';
import authModule from './stores/auth';
import coursesModule from "./stores/courses";
import examsModule from "./stores/exams";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth: authModule,
        courses: coursesModule,
        exam: examsModule,
    },
    state: {
        activeWindow: 'main',// main|module
        snackbar: {},
        isLoading: false,
        isTakingExam: false,
    },
    getters: {
        ACTIVE_WINDOW: (state) => {
            return state.activeWindow;
        },
        SNACKBAR(state) {
            return state.snackbar;
        },
        LOADING(state) {
            return state.isLoading;
        },
    },
    mutations: {
        SET_ACTIVE_WINDOW: (state, payload) => {
            state.activeWindow = payload;
        },
        SET_SNACKBAR(state, payload) {
            state.snackbar = payload;
        },
        SET_LOADER(state, payload) {
            state.isLoading = payload;
        }
    },
    actions: {
        SET_ACTIVE_WINDOW: ({commit}, payload) => {
            commit('SET_ACTIVE_WINDOW', payload);
        },
        SET_SNACKBAR({commit}, payload) {
            let snackbar = {
                showing: true,
                text: payload.text,
                context: payload.context || "success",
                timeout: payload.timeout || 5000,
            };
            commit('SET_SNACKBAR', snackbar);
        },
        SET_LOADER({commit}, payload) {
            commit('SET_LOADER', payload);
        }
    },
});

