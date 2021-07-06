import {resolveError} from "../../utils/helpers";
import httpClient from "../../utils/httpClient";

export default {
    state: {
        user: null,
    },
    getters: {
        LOGGED_IN_USER(state) {
            return state.user || null;
        },
        IS_LOGGED_IN(state) {
            return !!state.user && !!state.user.id;
        },
        TINYMCE_API_KEY (state)  {
            if (!state.user) {
                return 'no-api-key';
            }
            return state.user.tinymceApiKey || 'no-api-key';
        },
        HAS_ACCESS(state){
            return (permission = '') => {
                return !!permission && !!state.user && !!state.user.permissions[permission];
            }
        },
        HAS_ANY_ACCESS(state){
            return (permissions = []) => {
                return !!state.user && permissions.some((permission) => !!state.user.permissions[permission]);
            }
        },
    },
    mutations: {
        SET_LOGGED_IN_USER (state, payload)  {
            state.user = payload || null;
        },
    },
    actions: {
        async LOGIN ({commit}, payload) {
            try {
                let response = await httpClient.post('/login', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async LOGOUT({commit}) {
            try {
                let response = await httpClient.post('/logout', {});
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_LOGGED_IN_USER ({commit}) {
            try {
                let response = await httpClient.get('/user-data');
                commit('SET_LOGGED_IN_USER', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
