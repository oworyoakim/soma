import Vue from 'vue';
import Vuex from 'vuex';
import authModule from './stores/auth';
import usersModule from './stores/users';
import coursesModule from "./stores/courses";
import examsModule from "./stores/exams";
import programsModule from "./stores/programs";
import levelsModule from "./stores/levels";
import intakesModule from "./stores/intakes";
import enrollmentsModule from "./stores/enrollments";
import studentsModule from "./stores/students";
import instructorsModule from "./stores/instructors";
import classroomsModule from "./stores/classrooms";
import logbooksModule from "./stores/logbooks";
import {resolveError} from "./utils/helpers";
import {httpClient} from "./app";

Vue.use(Vuex);

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
        intakes: intakesModule,
        enrollments: enrollmentsModule,
        logbooks: logbooksModule,
    },
    state: {
        formSelectionOptions: {
            programs: [],
            intakes: [],
            courses: [],
            levels: [],
            users: [],
            students: [],
            roles: [],
            flightTypes: [],
            instructors: [],
        },
        isLoading: false,
        isTakingExam: false,
        preLoader: false,
        editorConfig: {
            height: 480,
            media_live_embeds: true,
            menubar: "insert edit format",
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen',
                'insertdatetime media table paste hr code wordcount',
                'toc'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image video code|toc'
        },
        dateTimeRangePickerConfig: {
            showDropdowns: true,
            singleDatePicker: true,
            timePickerIncrement: 5,
            timePicker: true,
            minDate: new Date(),
            opens: "center",
            drops: "up",
            locale: {
                format: 'YYYY-MM-DD HH:mm'
            }
        },

        singleDatePickerConfig: {
            showDropdowns: true,
            singleDatePicker: true,
            maxDate: new Date(),
            opens: "center",
            drops: "up",
            locale: {
                format: 'YYYY-MM-DD'
            }
        },
    },
    getters: {
        LOADING(state) {
            return state.isLoading;
        },
        PRE_LOADER(state) {
            return state.preLoader;
        },
        EDITOR_CONFIG(state) {
            return state.editorConfig;
        },
        IS_ACTIVE_PATH(state) {
            return (paths = []) => {
                return paths.includes(location.pathname);
            }
        },
        FORM_SELECTIONS_OPTIONS(state) {
            return state.formSelectionOptions;
        },
        singleDatePickerConfig(state){
            return state.singleDatePickerConfig;
        },
    },
    mutations: {
        SET_LOADER(state, payload) {
            state.isLoading = payload;
        },
        SET_PRELOADER(state, payload) {
            state.preLoader = payload;
        },
        SET_FORM_SELECTIONS_OPTIONS(state, payload) {
            state.formSelectionOptions = payload;
        },
        MODAL_OPEN(state, payload) {
            if (!!payload) {
                document.querySelector('body').classList.add("modal-open");
            } else {
                document.querySelector('body').classList.remove("modal-open");
            }
        },
    },
    actions: {
        async SET_SNACKBAR({commit}, payload) {
            const {context, message} = payload;
            // if (context === 'error') {
            //     toastr.error(message);
            // } else if (context === 'info') {
            //     toastr.info(message);
            // } else if (context === 'warning') {
            //     toastr.warning(message);
            // } else {
            //     toastr.success(message);
            // }
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
        SET_LOADER({commit}, payload) {
            commit('SET_LOADER', payload);
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
        async GET_FORM_SELECTIONS_OPTIONS({commit}) {
            try {
                let response = await httpClient.get('/v1/form-selections-options');
                commit("SET_FORM_SELECTIONS_OPTIONS", response.data);
                return Promise.resolve(response.data);
            } catch (error) {
                let message = resolveError(error);
                return Promise.reject(message);
            }
        }
    },
});

