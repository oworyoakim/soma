import {prepareQueryParams, resolveError} from "../utils/helpers";
import {httpClient} from "../app";

export default {
    state: {
        instructors: null,
        activeInstructor: null,
    },
    getters: {
        INSTRUCTORS(state) {
            return state.instructors;
        },
        ACTIVE_INSTRUCTOR(state, payload) {
            state.activeInstructor = payload || null;
        },
    },
    mutations: {
        SET_INSTRUCTORS(state, payload) {
            state.instructors = payload;
        },
        SET_ACTIVE_INSTRUCTOR(state, payload) {
            state.activeInstructor = payload;
        },
    },
    actions: {
        async GET_INSTRUCTORS({commit}, payload = {}) {
            try {
                let queryParams = prepareQueryParams(payload);
                let response = await httpClient.get('/v1/instructors' + queryParams);
                commit('SET_INSTRUCTORS', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_INSTRUCTOR({commit}, payload = {}) {
            try {
                let response = await httpClient.get('/v1/instructors/' + payload);
                commit('SET_ACTIVE_INSTRUCTOR', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_INSTRUCTOR({commit}, payload) {
            try {
                let response;
                if (!!payload.id) {
                    response = await httpClient.put('/v1/instructors', payload);
                } else {
                    response = await httpClient.post('/v1/instructors', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
