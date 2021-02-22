import {httpClient} from "../app";
import {resolveError} from "../utils/helpers";

export default {
    state: {
        levels: [],
    },
    getters: {
        LEVELS(state) {
            return state.levels;
        },
    },
    mutations: {
        SET_LEVELS(state, payload) {
            state.levels = payload;
        }
    },
    actions: {
        async GET_LEVELS({commit}, payload) {
            try {
                let response = await httpClient.get('/v1/levels');
                commit('SET_LEVELS', response.data);
                return Promise.resolve('Levels loaded!');
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_LEVEL({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/levels', payload);
                } else {
                    response = await httpClient.post('/v1/levels', payload);
                }
                dispatch("GET_LEVELS");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
