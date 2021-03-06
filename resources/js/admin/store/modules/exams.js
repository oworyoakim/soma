import httpClient from "../../../shared/utils/httpClient";
import {prepareQueryParams,resolveError} from "../../../shared/utils/helpers";

export default {
    state: {
        exams: [],
        intakes: [],
        examInfo: null,
        examQuestions: [],
        examStatus: "pending", // pending, ongoing, ended
    },
    getters: {
        EXAMS(state) {
            return state.exams;
        },
        EXAM_INFO(state) {
            let defaultInfo = {
                intakeId: 1,
                intakeTitle: "Intake 1",
                courseId: 10,
                courseTitle: "Course 1",
                studentId: 14,
                studentName: "Student 1",
                studentNumber: "STA0012",
                examId: 8,
                examDuration: 45,
                instructions: "",
                questions: [
                    {
                        id: 1,
                        title: 'Question 1.',
                        description: 'How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 21, title: 'Answer 1', selected: false},
                            {id: 23, title: 'Answer 2', selected: false},
                            {id: 25, title: 'Answer 3', selected: false},
                            {id: 26, title: 'Answer 4', selected: false},

                        ]
                    },
                    {
                        id: 2,
                        title: 'Question 2.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 31, title: 'Answer 1', selected: false},
                            {id: 32, title: 'Answer 2', selected: false},
                            {id: 33, title: 'Answer 3', selected: false},
                            {id: 34, title: 'Answer 4', selected: false},

                        ]
                    },
                    {
                        id: 3,
                        title: 'Question 3.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 41, title: 'Answer 1', selected: false},
                            {id: 42, title: 'Answer 2', selected: false},
                            {id: 43, title: 'Answer 3', selected: false},
                            {id: 44, title: 'Answer 4', selected: false},

                        ]
                    },
                    {
                        id: 4,
                        title: 'Question 4.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 51, title: 'Answer 1', selected: false},
                            {id: 52, title: 'Answer 2', selected: false},
                            {id: 53, title: 'Answer 3', selected: false},
                            {id: 54, title: 'Answer 4', selected: false},

                        ]
                    },
                    {
                        id: 5,
                        title: 'Question 5.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 61, title: 'Answer 1', selected: false},
                            {id: 62, title: 'Answer 2', selected: false},
                            {id: 63, title: 'Answer 3', selected: false},
                            {id: 64, title: 'Answer 4', selected: false},

                        ]
                    },
                    {
                        id: 6,
                        title: 'Question 6.',
                        description: 'How do you initiate a flight?',
                        answered: false,
                        answers: [
                            {id: 71, title: 'Answer 1', selected: false},
                            {id: 72, title: 'Answer 2', selected: false},
                            {id: 73, title: 'Answer 3', selected: false},
                            {id: 74, title: 'Answer 4', selected: false},

                        ]
                    },
                ],
            };
            return state.examInfo || defaultInfo;
        },
        EXAM_STATUS(state) {
            return state.examStatus || "pending";
        },
        EXAM_QUESTIONS(state) {
            return state.examQuestions || [];
        }
    },
    mutations: {
        SET_EXAM_INFO(state, payload) {
            state.examInfo = payload;
        },
        SET_EXAM_STATUS(state, payload) {
            state.examStatus = payload;
        },
        SET_EXAMS(state, payload) {
            state.exams = payload;
        },
        SET_EXAM_QUESTIONS(state, payload) {
            state.examQuestions = payload;
        }
    },
    actions: {
        async GET_EXAMS({commit}, payload = {})  {
            try {
                let params = prepareQueryParams(payload);
                let response = await httpClient.get('/v1/exams' + params);
                commit('SET_EXAMS', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async SAVE_EXAM({commit}, payload) {
            try {
                let response;
                if (!!payload.id) {
                    response = await httpClient.put('/v1/exams', payload);
                } else {
                    response = await httpClient.post('/v1/exams', payload);
                }
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
        async GET_EXAM_INFO({commit}, payload) {
            try {
                let params = prepareQueryParams(payload);
                let response = await httpClient.get('/v1/exam/info' + params);
                commit('SET_EXAM_INFO', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },

        async GET_EXAM_QUESTIONS({commit}, payload) {
            try {
                if(!payload.examId){
                    throw new Error("Exam ID required!");
                }
                let response = await httpClient.get('/v1/exam/questions?examId=' + payload.examId);
                commit('SET_EXAM_QUESTIONS', response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        },
    },
}
