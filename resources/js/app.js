require("./bootstrap");

import Vue from "vue";

import Login from "./components/Auth/Login";
import StudentDashboard from "./components/Student/Dashboard";
import StudentProfile from "./components/Student/Profile";
import StudentCourses from "./components/Student/Courses";
import AdminDashboard from "./components/Admin/Dashboard";
import Spinner from "./components/Shared/Spinner";
import MainSidebar from "./components/MainSidebar";
import MainFooter from "./components/MainFooter";
import MainNavbar from "./components/MainNavbar";
import StudentNavbar from "./components/StudentNavbar";
import ManageCourses from "./components/Admin/Courses/Index";
import ManageLiveClasses from "./components/Admin/LiveClasses/Index";
import ManageUsers from "./components/Admin/Users/Index";
import ManageRoles from "./components/Admin/Roles/Index";
import ManageStudents from "./components/Admin/Students/Index";
import ManageInstructors from "./components/Admin/Instructors/Index";
import ManagePrograms from "./components/Admin/Programs/Index";
import ManageLevels from "./components/Admin/Levels/Index";
import ManageExams from "./components/Admin/Exams/Index";
import ManageLogbooks from "./components/Admin/Logbooks/Index";
import ManageEnrollments from "./components/Admin/Enrollments/Index";
import ManageIntakes from "./components/Admin/Intakes/Index";

Vue.component("app-login", Login);
Vue.component("app-spinner", Spinner);
Vue.component("app-main-navbar", MainNavbar);
Vue.component("app-student-navbar", StudentNavbar);
Vue.component("app-main-sidebar", MainSidebar);
Vue.component("app-main-footer", MainFooter);
Vue.component("app-admin-dashboard", AdminDashboard);
Vue.component("app-manage-courses", ManageCourses);
Vue.component("app-manage-live-classes", ManageLiveClasses);
Vue.component("app-manage-users", ManageUsers);
Vue.component("app-manage-roles", ManageRoles);
Vue.component("app-manage-students", ManageStudents);
Vue.component("app-manage-instructors", ManageInstructors);
Vue.component("app-manage-programs", ManagePrograms);
Vue.component("app-manage-levels", ManageLevels);
Vue.component("app-manage-intakes", ManageIntakes);
Vue.component("app-manage-exams", ManageExams);
Vue.component("app-manage-logbooks", ManageLogbooks);
Vue.component("app-manage-enrollments", ManageEnrollments);

// Student
Vue.component('app-student-dashboard', StudentDashboard);
Vue.component('app-student-profile', StudentProfile);
Vue.component('app-student-courses', StudentCourses);

// Create an Event Bus for communications
const EventBus = new Vue();
window.EventBus = EventBus;
// base URL
Vue.mixin({
    computed: {
        baseUrl(){
            return baseUrl;
        }
    },
    methods: {
        deepClone(object) {
            return JSON.parse(JSON.stringify(object));
        },
    },
});

let baseUrl = null;
let csrfToken = null;
let baseUrlElement = document.head.querySelector('meta[name="base-url"]');
let csrfTokenElement = document.head.querySelector('meta[name="csrf-token"]');

if (baseUrlElement) {
    baseUrl = baseUrlElement.content || null;
}
if (csrfTokenElement) {
    csrfToken = csrfTokenElement.content || null;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Configure Axios for HTTP Requests
const axios = require('axios');
const httpClient = axios.create({
    baseURL: baseUrl, // Register the Application base URL
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Register the CSRF Token
    },
    timeout: 10000,
});
// To cancel duplicate requests occurring less than 30 seconds apart,
// We need to keep track of the current requests that are being executed
/*
let currentExecutingRequests = {};
httpClient.interceptors.request.use((request) => {
    let url = request.url || null;
    let now = moment();
    let method = request.method;
    let key = `${method}:${url}`
    if(!currentExecutingRequests[key]){
        currentExecutingRequests[key] = now;
        return request;
    }
    let lastRequestTime = moment(currentExecutingRequests[key]).add(10,'second');
    if(lastRequestTime.isSameOrBefore(now)){
        currentExecutingRequests[key] = now;
        return request;
    }
    // console.log("INTERCEPTED DUPLICATE REQUEST: ",key);
    // throw new axios.Cancel("Request cancelled because the same request was made less than 30 seconds ago!");
    return {
        ...request,
        cancelToken: new axios.CancelToken((cancel) => {
            console.log('INTERCEPTED DUPLICATE REQUEST: ', key);
            cancel('Cancelled repeated request!');
        })
    };
}, (error) => {
    return Promise.reject(error);
})
*/
Vue.prototype.$httpClient = httpClient;

export {
    baseUrl,
    httpClient,
    EventBus,
};

import store from "./store";
import {resolveError} from "./utils/helpers";


const app = new Vue({
    el: "#main-app",
    store,
});

// Initialize the app
initApp(app);

/**
 * Load levels and user data immediately  after initializing the vue app
 * @param app {Vue}
 * @returns {Promise<String>}
 */
async function initApp(app) {
    try {
        let response;
        app.$store.commit("SET_PRELOADER", true);
        response = await app.$store.dispatch("GET_LOGGED_IN_USER");
        console.log(response);
        response = await app.$store.dispatch("GET_LEVELS");
        console.log(response);
        app.$store.commit("SET_PRELOADER", false);
        return Promise.resolve("Application Initialized!");
    } catch (error) {
        app.$store.commit("SET_PRELOADER", false);
        let message = resolveError(error);
        return Promise.reject(message);
    }
}
