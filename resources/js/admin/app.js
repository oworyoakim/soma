require("./bootstrap");

import Vue from "vue";

import Login from "./components/Auth/Login";
import AdminDashboard from "./components/Dashboard";
import Spinner from "../shared/components/Spinner";
import MainSidebar from "./components/MainSidebar";
import MainFooter from "./components/MainFooter";
import MainNavbar from "./components/MainNavbar";
import ManageCourses from "./components/Courses/Index";
import ManageCourse from "./components/Courses/CourseDetails";
import ManageCourseModules from "./components/Modules/CourseModules";
import ManageCourseTopics from "./components/Topics/CourseTopics";
import ManageLiveClasses from "./components/LiveClasses/Index";
import ManageUsers from "./components/Users/Index";
import ManageRoles from "./components/Roles/Index";
import ManageStudents from "./components/Students/Index";
import ManageInstructors from "./components/Instructors/Index";
import ManageLevels from "./components/Levels/Index";
import ManageExams from "./components/Exams/Index";
import ManageEnrollments from "./components/Enrollments/Index";

Vue.component("app-login", Login);
Vue.component("app-spinner", Spinner);
Vue.component("app-main-navbar", MainNavbar);
Vue.component("app-main-sidebar", MainSidebar);
Vue.component("app-main-footer", MainFooter);
Vue.component("app-admin-dashboard", AdminDashboard);
Vue.component("app-manage-courses", ManageCourses);
Vue.component("app-manage-course", ManageCourse);
Vue.component("app-manage-course-modules", ManageCourseModules);
Vue.component("app-manage-course-topics", ManageCourseTopics);
Vue.component("app-manage-live-classes", ManageLiveClasses);
Vue.component("app-manage-users", ManageUsers);
Vue.component("app-manage-roles", ManageRoles);
Vue.component("app-manage-students", ManageStudents);
Vue.component("app-manage-instructors", ManageInstructors);
Vue.component("app-manage-levels", ManageLevels);
Vue.component("app-manage-exams", ManageExams);
Vue.component("app-manage-enrollments", ManageEnrollments);

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
let baseUrlElement = document.head.querySelector('meta[name="base-url"]');
if (baseUrlElement) {
    baseUrl = baseUrlElement.content || null;
}

export {
    baseUrl,
    EventBus,
};

import store from "./store";
import {resolveError} from "../shared/utils/helpers";


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
        console.log("User: ", response);
        app.$store.commit("SET_PRELOADER", false);
        return Promise.resolve("Application Initialized!");
    } catch (error) {
        app.$store.commit("SET_PRELOADER", false);
        let message = resolveError(error);
        return Promise.reject(message);
    }
}
