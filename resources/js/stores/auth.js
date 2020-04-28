import axios from 'axios';

export default {
    state: {
        user: null,
        users: [],
        roles: [],
        permissions: [],
    },
    getters: {
        LOGGED_IN_USER: (state) => {
            return state.user || {};
        },
        USERS: (state) => {
            return state.users || [];
        },
        ROLES: (state) => {
            return state.roles || [];
        },
        PERMISSIONS: (state) => {
            return state.permissions || [];
        },
    },
    mutations: {
        SET_LOGGED_IN_USER: (state, payload) => {
            state.user = payload;
        },
        SET_USERS: (state, payload) => {
            state.users = payload;
        },
        SET_ROLES: (state, payload) => {
            state.roles = payload;
        },
        SET_PERMISSIONS: (state, payload) => {
            state.permissions = payload;
        }
    },
    actions: {
        LOGIN: async ({commit}, payload) => {
            try {
                let response = await axios.post('/login', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        LOGOUT: async ({commit}) => {
            try {
                let response = await axios.post('/logout', {});
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        GET_LOGGED_IN_USER: async ({commit}) => {
            try {
                let response = await axios.get('/user-data');
                commit('SET_LOGGED_IN_USER', response.data);
                return Promise.resolve('Ok');
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },

        GET_USERS: async ({commit}) => {
            try {
                let response = await axios.get('/v1/users');
                commit('SET_USERS', response.data);
                return Promise.resolve('Ok');
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },

        GET_ROLES: async ({commit}) => {
            try {
                let response = await axios.get('/v1/roles');
                commit('SET_ROLES', response.data.roles);
                commit('SET_PERMISSIONS', response.data.permissions);
                return Promise.resolve('Ok');
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_USER: async ({commit}, payload) => {
            try {
                let response;
                if (payload.id) {
                    response = await axios.put('/v1/users', payload);
                } else {
                    response = await axios.post('/v1/users', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_ROLE: async ({commit}, payload) => {
            try {
                let response;
                if (payload.id) {
                    response = await axios.put('/v1/roles', payload);
                } else {
                    response = await axios.post('/v1/roles', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        UPDATE_PERMISSIONS: async ({commit}, payload) => {
            try {
                let response = await axios.patch('/v1/roles', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
    },
}
