import httpClient from "../utils/httpClient";
import {prepareQueryParams} from "../utils/helpers";

export default {
    async SET_SNACKBAR({commit}, payload) {
        const {context, message} = payload;
        const Toast = SweetAlert.mixin({
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: context || 'success',
            text: message,
        });
    },
    async SWEET_ALERT({commit}, payload) {
        const {context, message} = payload;
        let html = document.createElement('div');
        html.innerHTML = message;
        SweetAlert.fire({
            html: html,
            icon: context || 'success',
        });
    },
    async GET_FORM_SELECTIONS_OPTIONS({commit}, payload = {}) {
        try {
            let params = prepareQueryParams(payload);
            let response = await httpClient.get('/v1/form-selections-options' + params);
            commit("SET_FORM_SELECTIONS_OPTIONS", response.data);
            return Promise.resolve(response.data);
        } catch (error) {
            let message = resolveError(error);
            return Promise.reject(message);
        }
    }
}
