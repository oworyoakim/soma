import {httpClient} from "../app";
import {resolveError} from "../utils/helpers";

export default {
    state: {
        intakes: [],
    },
    getters: {
        INTAKES: (state) => {
            return state.intakes;
        },
    },
    mutations: {
        SET_INTAKES: (state, payload) => {
            state.intakes = payload;
        }
    },
    actions: {
        async GET_INTAKES ({commit}, payload) {
            try {
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/intakes');
                commit('SET_INTAKES', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve(response.data);
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_INTAKE ({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/intakes', payload);
                } else {
                    response = await httpClient.post('/v1/intakes', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
