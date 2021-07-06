import globalActions from "../../shared/store/actions";
import httpClient from "../../shared/utils/httpClient";
import {prepareQueryParams, resolveError} from "../../shared/utils/helpers";
export default {
    ...globalActions,
    async LOGIN_ADMIN({commit}, payload){
        try {
            let response = await httpClient.post('/admin-login', payload);
            return Promise.resolve(response.data);
        } catch (error) {
            let message = resolveError(error);
            return Promise.reject(message);
        }
    },
    async GET_DASHBOARD_STATISTICS({commit}, payload = {}) {
        let setsLoader = payload.setsLoader || false;
        try {
            let queryParams = prepareQueryParams(payload);
            if(setsLoader){
                commit('SET_LOADER', true);
            }
            let response = await httpClient.get('/v1/dashboard-statistics' + queryParams);
            commit('SET_DASHBOARD_STATISTICS', response.data);
            if(setsLoader){
                commit('SET_LOADER', false);
            }
            return Promise.resolve(response.data);
        } catch (error) {
            if(setsLoader){
                commit('SET_LOADER', false);
            }
            let message = resolveError(error);
            return Promise.reject(message);
        }
    },
}
