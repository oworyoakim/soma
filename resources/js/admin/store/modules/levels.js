import httpClient from "../../../shared/utils/httpClient";
import {prepareQueryParams,resolveError} from "../../../shared/utils/helpers";


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
        async GET_LEVELS({commit}, payload = {}) {
            let setsLoader = payload.setsLoader || false;
            try {
                if(setsLoader){
                    commit('SET_LOADER', true);
                }
                let response = await httpClient.get('/v1/levels');
                commit('SET_LEVELS', response.data);
                if(setsLoader){
                    commit('SET_LOADER', false);
                }
                return Promise.resolve('Levels loaded!');
            } catch (error) {
                if(setsLoader){
                    commit('SET_LOADER', false);
                }
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
