import {prepareQueryParams, resolveError} from "../utils/helpers";
import {httpClient} from "../app";

export default {
    state: {
        classrooms: [],
        activeClassroom: null,
    },
    getters: {
        CLASSROOMS(state) {
            return state.classrooms || [];
        },
        ACTIVE_CLASSROOM(state) {
            return state.activeClassroom;
        },
    },
    mutations: {
        SET_CLASSROOMS(state, payload) {
            state.classrooms = payload;
        },
        SET_ACTIVE_CLASSROOM(state, payload) {
            state.activeClassroom = payload;
        },
    },
    actions: {
        async GET_CLASSROOMS({commit}, payload = {}) {
            try {
                let queryParams = prepareQueryParams(payload);
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/classrooms' + queryParams);
                commit('SET_CLASSROOMS', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve(response.data);
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_CLASSROOM_DETAILS ({commit}, payload) {
            try {
                if (!payload.classroomId) {
                    return Promise.reject("Classroom ID required!");
                }
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/classrooms/' + payload.classroomId);
                commit('SET_ACTIVE_CLASSROOM', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve(response.data);
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_CLASSROOM({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/classrooms', payload);
                } else {
                    response = await httpClient.post('/v1/classrooms', payload);
                }
                dispatch("GET_CLASSROOMS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
