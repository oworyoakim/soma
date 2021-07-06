import httpClient from "../../../shared/utils/httpClient";
import {prepareQueryParams,resolveError} from "../../../shared/utils/helpers";


export default {
    state: {
        enrollments: null,
    },
    getters: {
        ENROLLMENTS(state) {
            return state.enrollments;
        },
    },
    mutations: {
        SET_ENROLLMENTS(state, payload) {
            state.enrollments = payload;
        }
    },
    actions: {
        async GET_ENROLLMENTS ({commit}, payload) {
            try {
                let params = prepareQueryParams(payload);
                let response = await httpClient.get('/v1/enrollments' + params);
                commit('SET_ENROLLMENTS', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_ENROLLMENT ({commit, dispatch}, payload) {
            try {
                let response = await httpClient.post('/v1/enrollments', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
