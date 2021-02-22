import {prepareQueryParams, resolveError} from "../utils/helpers";
import {httpClient} from "../app";

export default {
    state: {
        students: null,
        activeStudent: null,
        myCourses: [],
    },
    getters: {
        STUDENTS(state) {
            return state.students;
        },
        ACTIVE_STUDENT(state) {
            return state.activeStudent;
        },
        MY_COURSES(state) {
            return state.myCourses;
        },
    },
    mutations: {
        SET_STUDENTS(state, payload) {
            state.students = payload;
        },
        SET_ACTIVE_STUDENT(state, payload) {
            state.activeStudent = payload || null;
        },
        SET_MY_COURSES(state, payload) {
            state.myCourses = payload || [];
        },
    },
    actions: {
        async GET_STUDENTS({commit}, payload = {}) {
            try {
                let queryParams = prepareQueryParams(payload);
                let response = await httpClient.get('/v1/students' + queryParams);
                commit('SET_STUDENTS', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_STUDENT({commit}, payload = {}) {
            try {
                let response = await httpClient.get('/v1/students/' + payload);
                commit('SET_ACTIVE_STUDENT', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_STUDENT({commit}, payload) {
            try {
                let response;
                if (!!payload.id) {
                    response = await httpClient.put('/v1/students', payload);
                } else {
                    response = await httpClient.post('/v1/students', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },

        async GET_MY_COURSES({commit}) {
            try {
                let response = await httpClient.get('/v1/my-courses');
                commit('SET_MY_COURSES', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
