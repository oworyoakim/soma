import axios from 'axios';

export default {
    state: {
        // courses: [],
        courses: [
            {
                id: 1,
                title: "Java 11 Developer",
                slug: "java-11-developer",
                description: "In this course, step by step, We will show you how to build web applications with Laravel 6. We will start with the basics and incrementally dig deeper and deeper, as we review real-life examples. Once complete, you should have all the tools you need. Let's get to work!",
                outline: "Course 1 Outline",
                outcome: "Course 1 Outcome",
                thumbnail: "https://cdn.vuetifyjs.com/images/cards/docks.jpg",
                duration: 45,
                numEnrolled: 30,
                numModules: 9,
                weight: 4,
                canBeEnrolledFor: true,
                canTakeExam: false,
                modules: [
                    {
                        id: 1,
                        title: "Routing",
                        description: " Scratch is supposed to be a Quick introduction to new Users. In my case I am taking this course as refresh since, it's been months I don't touch laravel. So yes I forgot the basics and this is very helpful.",
                        topics: [
                            {
                                id: 1,
                                title: "Topic 1kkk",
                                body:"<p>This is a simple example to demonstrate usage of v-html</p><a href=”#”>Read more</a>",
                                materials: [
                                    {
                                        id: 1,
                                        title: "Material 1",
                                        type: "video",
                                        path: "/videos/video1.mp4",
                                    }
                                ]
                            },
                            {
                                id: 2,
                                title: "Topic 2lkkk",
                                body:"<h3>Scratch is <h1><a>supposed to be</a> a Quick introduction to new Users.",
                            },
                            {
                                id: 3,
                                title: "Topic 3lll",
                                body:'Scratch is supposed to be a Quick <p>introduction to new Users.<p>',
                            },
                            {
                                id: 4,
                                title: "Topic 4mnj",
                                body:"Scratch is supposed to be a <h2>Quick introduction</h2> to new Users.",
                            },
                            {
                                id: 5,
                                title: "Topic 5pp",
                                body:"Scratch is supposed to be a <a>Quick</a> introduction to <h1>new</h1> Users.",
                            }
                        ]
                    },
                    {
                        id: 2,
                        title: "Programming",
                        description: "Situation admitting promotion at or to perceived be. Mr acuteness we as estimable enjoyment up. An held late as felt know. Learn do allow solid to grave.",
                        topics: [
                            {
                                id: 1,
                                title: "Topic 1",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                                materials: [
                                    {
                                        id: 1,
                                        title: "Material 1",
                                        type: "video",
                                        path: "/videos/video1.mp4",
                                    }
                                ]
                            },
                            {
                                id: 2,
                                title: "Topic 2",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 4,
                                title: "Topic 4",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            }
                        ]
                    },
                    {
                        id: 3,
                        title: "Scheduling",
                        description: "Extremity sweetness difficult behaviour he of. On disposal of as landlord horrible. Afraid at highly months do things on at. Situation recommend objection do intention so questions. As greatly removed calling pleased improve an.",
                        topics: [
                            {
                                id: 1,
                                title: "Topic 1",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                                materials: [
                                    {
                                        id: 1,
                                        title: "Material 1",
                                        type: "video",
                                        path: "/videos/video1.mp4",
                                    }
                                ]
                            },
                            {
                                id: 2,
                                title: "Topic 2",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 4,
                                title: "Topic 4",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            }
                        ]
                    }
                ]
            },
            {
                id: 2,
                title: "Data Structures & Algorithms",
                slug: "data-structures-&-algorithms",
                description: "In this course you will learn data structures and algorithms by solving 80+ practice problems. You will begin each course by learning to solve defined problems related to a particular data structure and algorithm. By the end of each course, you would be able to evaluate and assess different data structures and algorithms for any open-ended problem and implement a solution based on your design choices.",
                outline: "Course 1 Outline",
                outcome: "Course 1 Outcome",
                thumbnail: "https://cdn.vuetifyjs.com/images/cards/docks.jpg",
                duration: 30,
                numEnrolled: 20,
                numModules: 6,
                weight: 3,
                canBeEnrolledFor: true,
                canTakeExam: true,
                modules: [
                    {
                        id: 2,
                        title: "Routing",
                        description: "Yourself required no at thoughts delicate landlord it be. Branched dashwood do is whatever it. Farther be chapter at visited married in it pressed. By distrusts procuring be oh frankness existence believing instantly if. Doubtful on an juvenile as of servants insisted",
                        topics: [
                            {
                                id: 1,
                                title: "Topic 1",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 2,
                                title: "Topic 2",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 3,
                                title: "Topic 3",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 4,
                                title: "Topic 4",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            }
                        ]
                    },
                    {
                        id: 4,
                        title: "Many-to-Many Eloquent Relationships",
                        description: "Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources. ",
                        topics: [
                            {
                                id: 1,
                                title: "Introduction",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                                
                            },
                            {
                                id: 2,
                                title: "Understanding Relations",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 3,
                                title: "Understanding Many to many",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 4,
                                title: "Eloquent relations",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            },
                            {
                                id: 5,
                                title: "Summary",
                                body:"Scratch is supposed to be a Quick introduction to new Users.",
                            }
                        ]
                    }
                ]
            }
        ],
        activeCourse: null,
        activeModule: null,
    },
    getters: {
        COURSES: (state) => {
            return state.courses || [];
        },
        ACTIVE_COURSE: (state) => {
            return state.activeCourse;
        },
        ACTIVE_MODULE: (state) => {
            return state.activeModule;
        }
    },
    mutations: {
        SET_COURSES: (state, payload) => {
            state.courses = payload;
        },
        SET_ACTIVE_COURSE: (state, payload) => {
            state.activeCourse = payload;
        },
        SET_ACTIVE_MODULE: (state, payload) => {
            state.activeModule = payload;
        }
    },
    actions: {
        GET_COURSES: async ({commit}, payload) => {
            try {
                commit('SET_LOADER', true);
                let response = await axios.get('/v1/courses');
                commit('SET_COURSES', response.data);
                commit('SET_LOADER', false);
                return Promise.resolve("Ok");
            } catch (error) {
                commit('SET_LOADER', false);
                return Promise.reject(error.response.data);
            }
        },
        SAVE_COURSE: async ({commit,dispatch}, payload) => {
            try {
                let response;
                if(payload.id){
                    response = await axios.put('/v1/courses',payload);
                }else{
                    response = await axios.post('/v1/courses',payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_MODULE: async ({commit,dispatch}, payload) => {
            try {
                let response;
                if(payload.id){
                    response = await axios.put('/v1/modules',payload);
                }else{
                    response = await axios.post('/v1/modules',payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_TOPIC: async ({commit,dispatch}, payload) => {
            try {
                let response;
                if(payload.id){
                    response = await axios.put('/v1/topics',payload);
                }else{
                    response = await axios.post('/v1/topics',payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_QUESTION: async ({commit,dispatch}, payload) => {
            try {
                let response;
                if(payload.id){
                    response = await axios.put('/v1/questions',payload);
                }else{
                    response = await axios.post('/v1/questions',payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SAVE_ANSWER: async ({commit,dispatch}, payload) => {
            try {
                let response;
                if(payload.id){
                    response = await axios.put('/v1/answers',payload);
                }else{
                    response = await axios.post('/v1/answers',payload);
                }
                dispatch("GET_COURSES");
                return Promise.resolve(response.data);
            } catch (error) {
                return Promise.reject(error.response.data);
            }
        },
        SET_ACTIVE_COURSE: ({commit}, payload) => {
            commit('SET_ACTIVE_COURSE', payload);
        },
        SET_ACTIVE_MODULE: ({commit}, payload) => {
            commit('SET_ACTIVE_MODULE', payload);
        },
    },
}
