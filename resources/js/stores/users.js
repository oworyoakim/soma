import {httpClient} from "../app";
import {resolveError} from "../utils/helpers";

export default {
    state: {
        users: [],
        roles: [],
        permissions: [],
        activeUser: null,
    },
    getters: {
        USERS (state)  {
            return state.users || [];
        },
        ROLES (state)  {
            return state.roles || [];
        },
        PERMISSIONS (state)  {
            return state.permissions || [];
        },
        ACTIVE_USER (state)  {
            return state.activeUser || null;
        },
    },
    mutations: {
        SET_USERS (state, payload)  {
            state.users = payload;
        },
        SET_ROLES (state, payload)  {
            state.roles = payload;
        },
        SET_PERMISSIONS (state, payload)  {
            state.permissions = payload;
        }
    },
    actions: {
        async GET_USERS ({commit}) {
            try {
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/users');
                commit('SET_USERS', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve('Ok');
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_USER({commit}, payload) {
            try {
                let response = await httpClient.get('/v1/users/' + payload);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_ROLES ({commit}) {
            try {
                let response = await httpClient.get('/v1/roles');
                commit('SET_ROLES', response.data.roles);
                commit('SET_PERMISSIONS', response.data.permissions);
                return Promise.resolve('Ok');
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_USER ({commit}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/users', payload);
                } else {
                    response = await httpClient.post('/v1/users', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_ROLE ({commit}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/roles', payload);
                } else {
                    response = await httpClient.post('/v1/roles', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async UPDATE_PERMISSIONS ({commit}, payload) {
            try {
                let response = await httpClient.patch('/v1/roles', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    }
}
