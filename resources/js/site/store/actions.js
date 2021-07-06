import httpClient from "../../shared/utils/httpClient";
import globalActions from "../../shared/store/actions";
import {prepareQueryParams, resolveError} from "../../shared/utils/helpers";
export default {
    ...globalActions,
    async GET_LEARNING_PATHS({commit}){
        try {
            let response = await httpClient.get('/learning-paths');
            commit('SET_LEARNING_PATHS', response.data);
            return Promise.resolve(response.data);
        } catch (error) {
            let message = resolveError(error);
            return Promise.reject(message);
        }
    },
}
