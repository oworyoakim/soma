import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
import authModule from '../../shared/store/modules/auth';
import usersModule from './modules/users';
import coursesModule from "./modules/courses";
import examsModule from "./modules/exams";
import programsModule from "./modules/programs";
import levelsModule from "./modules/levels";
import enrollmentsModule from "./modules/enrollments";
import studentsModule from "./modules/students";
import instructorsModule from "./modules/instructors";
import classroomsModule from "./modules/classrooms";

import globalState from "../../shared/store/state";

import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";


export default new Vuex.Store({
    modules: {
        auth: authModule,
        users: usersModule,
        courses: coursesModule,
        classrooms: classroomsModule,
        exam: examsModule,
        programs: programsModule,
        levels: levelsModule,
        students: studentsModule,
        instructors: instructorsModule,
        enrollments: enrollmentsModule,
    },
    state: {
        ...globalState,
        isLoading: false,
        isTakingExam: false,
        preLoader: false,
        dashboardStatistics: {
            levels: 21,
            courses: 113,
            instructors: 17,
            students: 1230,
            examsTaken: 405,
            ongoingClasses: 6,
            upcomingClasses: 56,
            topics: 2342,
        },
    },
    getters,
    mutations,
    actions,
});
