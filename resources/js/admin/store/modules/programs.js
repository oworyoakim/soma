import httpClient from "../../../shared/utils/httpClient";
import {prepareQueryParams,resolveError} from "../../../shared/utils/helpers";

export default {
    state: {
        programs: [],
        activeProgram: null,
    },
    getters: {
        PROGRAMS(state) {
            return state.programs;
        },
        ACTIVE_PROGRAM(state) {
            return state.activeProgram;
        },
    },
    mutations: {
        SET_PROGRAMS(state, payload) {
            state.programs = payload;
        },
        SET_ACTIVE_PROGRAM(state, payload) {
            state.activeProgram = payload;
            if(payload){
                this.dispatch("GET_COURSES", {
                    programId: payload.id,
                });
            }
        },
    },
    actions: {
        async GET_PROGRAMS({commit}, payload = {}) {
            try {
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/programs');
                commit('SET_PROGRAMS', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve(response.data);
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_PROGRAM({commit, dispatch}, payload = {}) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/programs', payload);
                } else {
                    response = await httpClient.post('/v1/programs', payload);
                }
                //dispatch("GET_PROGRAMS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_PROGRAM({commit, dispatch}, payload = {}) {
            try {
                if (!payload.id) {
                    throw new Error('Program ID required!');
                }
                let response = await httpClient.get('/v1/programs/' + payload.id);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
