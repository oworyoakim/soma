import axios from 'axios';

export default {
    state: {
        exams: [],
        intakes: [],
        examInfo: null,
        examStatus: "pending", // pending, ongoing, ended
    },
    getters: {
        EXAMS: (state) => {
            return state.exams;
        },
        EXAM_INFO: (state) => {
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
        EXAM_STATUS: (state) => {
            return state.examStatus || "pending";
        }
    },
    mutations: {
        SET_EXAM_INFO: (state, payload) => {
            state.examInfo = payload;
        },
        SET_EXAM_STATUS: (state, payload) => {
            state.examStatus = payload;
        },
        SET_EXAMS: (state, payload) => {
            state.exams = payload;
        }
    },
    actions: {
        GET_EXAMS: async ({commit}, payload) => {
            try {
                let response = await axios.get('/exams?slug=' + payload);
                commit('SET_EXAMS', response.data);
                return Promise.resolve('Ok');
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        GET_EXAM_INFO: async ({commit}, payload) => {
            try {
                let response = await axios.get('/exam/info?slug=' + payload);
                commit('SET_EXAM_INFO', response.data);
                return Promise.resolve('Ok');
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SET_EXAM_STATUS: ({commit}, payload) => {
            commit('SET_EXAM_STATUS', payload);
        },
    },
}
