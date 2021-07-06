require("./bootstrap");
import Vue from "vue";
import store from "./store/index";
import StudentDashboard from "./components/Student/Dashboard";
import StudentProfile from "./components/Student/Profile";
import StudentCourses from "./components/Student/Courses";
import StudentNavbar from "./components/Student/Navbar";

Vue.component("site-header", require('./components/SiteHeader.vue').default);
Vue.component("site-footer", require('./components/SiteFooter.vue').default);
Vue.component("site-login-form", require('./components/Auth/LoginForm.vue').default);
Vue.component("site-signup-form", require('./components/Auth/SignupForm.vue').default);
Vue.component("site-forgot-password-form", require('./components/Auth/ForgotPasswordForm.vue').default);
Vue.component("site-home", require('./components/Home/Index.vue').default);
Vue.component("about-us", require('./components/Home/About.vue').default);
Vue.component("courses", require('./components/Courses/Index.vue').default);
Vue.component("primary-courses", require('./components/Courses/Primary.vue').default);
Vue.component("lower-secondary-courses", require('./components/Courses/LowerSecondary.vue').default);
Vue.component("upper-secondary-courses", require('./components/Courses/UpperSecondary.vue').default);
Vue.component("instructors", require('./components/Instructors/Index.vue').default);
// Student
Vue.component("student-navbar", StudentNavbar);
Vue.component('student-dashboard', StudentDashboard);
Vue.component('student-profile', StudentProfile);
Vue.component('student-courses', StudentCourses);


const siteApp = new Vue({
    el: "#site-app",
    store,
});

siteApp.$store.dispatch("GET_LOGGED_IN_USER");
