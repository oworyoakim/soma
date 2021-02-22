import {httpClient} from "../app";
import {resolveError} from "../utils/helpers";

export default {
    state: {
        logbooks: [],
    },
    getters: {
        LOGBOOKS(state) {
            return state.logbooks;
        },
    },
    mutations: {
        SET_LOGBOOKS(state, payload) {
            state.logbooks = payload;
        }
    },
    actions: {
        async GET_LOGBOOKS({commit}, payload) {
            try {
                let response = await httpClient.get('/v1/logbooks');
                commit('SET_LOGBOOKS', response.data);
                return Promise.resolve('Logbooks loaded!');
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_LOGBOOK({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/logbooks', payload);
                } else {
                    response = await httpClient.post('/v1/logbooks', payload);
                }
                dispatch("GET_LOGBOOKS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async APPROVE_LOGBOOK({commit, dispatch}, payload) {
            try {
                let response = await httpClient.patch('/v1/logbooks/approve', payload);
                dispatch("GET_LOGBOOKS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async DECLINE_LOGBOOK({commit, dispatch}, payload) {
            try {
                let response = await httpClient.patch('/v1/logbooks/decline', payload);
                dispatch("GET_LOGBOOKS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
