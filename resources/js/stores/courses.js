import {prepareQueryParams, resolveError} from "../utils/helpers";
import {httpClient} from "../app";

export default {
    state: {
        courses: [],
        modules: [],
        topics: [],
        activeCourse: null,
        activeModule: null,
        activeTopic: null,
        activeQuestion: null,
    },
    getters: {
        COURSES(state) {
            return state.courses || [];
        },
        MODULES(state) {
            return state.modules || [];
        },
        TOPICS(state) {
            return state.topics || [];
        },
        ACTIVE_COURSE(state) {
            return state.activeCourse;
        },
        ACTIVE_MODULE(state) {
            return state.activeModule;
        },
        ACTIVE_TOPIC(state) {
            return state.activeTopic;
        },
        ACTIVE_QUESTION(state) {
            return state.activeQuestion;
        },
    },
    mutations: {
        SET_COURSES(state, payload) {
            state.courses = payload;
        },
        SET_MODULES(state, payload) {
            state.modules = payload;
        },
        SET_TOPICS(state, payload) {
            state.topics = payload;
        },
        SET_ACTIVE_COURSE(state, payload) {
            state.activeCourse = payload;
        },
        SET_ACTIVE_MODULE(state, payload) {
            state.activeModule = payload;
        },
        SET_ACTIVE_TOPIC(state, payload) {
            state.activeTopic = payload;
        },
        SET_ACTIVE_QUESTION(state, payload) {
            state.activeQuestion = payload;
        },
    },
    actions: {
        async GET_COURSES({commit}, payload = {}) {
            try {
                let setsLoader = payload.setsLoader || false;
                let queryParams = prepareQueryParams(payload);
                if(setsLoader){
                    commit('SET_LOADER', true);
                }
                let response = await httpClient.get('/v1/courses' + queryParams);
                commit('SET_COURSES', response.data);
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
        async GET_MODULES({commit}, payload = {}) {
            try {
                let setsLoader = payload.setsLoader || false;
                let queryParams = prepareQueryParams(payload);
                if(setsLoader){
                    commit('SET_LOADER', true);
                }
                let response = await httpClient.get('/v1/modules' + queryParams);
                commit('SET_MODULES', response.data);
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
        async GET_TOPICS({commit}, payload = {}) {
            try {
                let setsLoader = payload.setsLoader || false;
                let queryParams = prepareQueryParams(payload);
                if(setsLoader){
                    commit('SET_LOADER', true);
                }
                let response = await httpClient.get('/v1/topics' + queryParams);
                commit('SET_TOPICS', response.data);
                if(payload.setsLoader) {
                    commit('SET_LOADER', false);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                if(payload.setsLoader) {
                    commit('SET_LOADER', false);
                }
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_MODULE_DETAILS ({commit}, payload) {
            try {
                if (!payload.moduleId) {
                    return Promise.reject("Module ID required!");
                }
                commit('SET_LOADER', true);
                let response = await httpClient.get('/v1/modules/' + payload.moduleId);
                commit('SET_ACTIVE_MODULE', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve("Ok");
            } catch (error) {
                commit('SET_LOADER', false);
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_COURSE({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/courses', payload);
                } else {
                    response = await httpClient.post('/v1/courses', payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },

        async UPDATE_COURSE_DESCRIPTION({commit, dispatch}, payload) {
            try {
                let response = await httpClient.patch('/v1/courses', payload);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_MODULE({commit}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/modules', payload);
                } else {
                    response = await httpClient.post('/v1/modules', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_TOPIC({commit}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/topics', payload);
                } else {
                    response = await httpClient.post('/v1/topics', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_TOPIC_DETAILS ({commit}, payload) {
            try {
                if (!payload.topicId) {
                    return Promise.reject("Topic ID required!");
                }
                let response = await httpClient.get('/v1/topics/' + payload.topicId);
                commit('SET_ACTIVE_TOPIC', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_QUESTION({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/questions', payload);
                } else {
                    response = await httpClient.post('/v1/questions', payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_ANSWER({commit, dispatch}, payload) {
            try {
                let response;
                if (payload.id) {
                    response = await httpClient.put('/v1/answers', payload);
                } else {
                    response = await httpClient.post('/v1/answers', payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        SET_ACTIVE_COURSE({commit}, payload) {
            commit('SET_ACTIVE_COURSE', payload);
        },
        SET_ACTIVE_MODULE({commit}, payload) {
            commit('SET_ACTIVE_MODULE', payload);
        },
    },
}
