import Vue from 'vue';
import VueRouter from "vue-router";
import Home from "./components/Home";
import StudentCourses from "./components/Courses/Index";
import Courses from "./components/Courses/Courses";
import CoursesList from "./components/Courses/Admin/CoursesList";
import CourseDetails from "./components/Courses/CourseDetails";
import Admin from "./components/Admin";
import AdminCourseDetails from "./components/Courses/Admin/AdminCourseDetails";
import AdminCourses from "./components/Courses/Admin/Index";
import CourseModuleDetails from "./components/Courses/Admin/CourseModuleDetails";
import Users from "./components/Auth/Users";
import Roles from "./components/Auth/Roles";


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/my-courses',
        name: 'my-courses',
        component: StudentCourses,
        children:[
            {
                path: '',
                name: 'courses',
                component: Courses,
            },
            {
                path: ':slug',
                name: 'course-details',
                component: CourseDetails,
            },
        ]
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin,
        children: [{
                path: 'courses',
                name: 'admin-courses',
                component: AdminCourses,
                children: [{
                        path: '',
                        name: 'admin-courses-list',
                        component: CoursesList,
                    },
                    {
                        path: 'view/:slug',
                        name: 'admin-course-details',
                        component: AdminCourseDetails,
                    },
                    {
                        path: 'view/:slug/module/:moduleId',
                        name: 'admin-course-module-details',
                        component: CourseModuleDetails,
                    }
                ]
            },
            {
                path: 'users',
                name: 'manage-users',
                component: Users,
            },
            {
                path: 'roles',
                name: 'manage-roles',
                component: Roles,
            },
        ]
    },

];

export default new VueRouter({
    mode: 'history',
    routes: routes,
});
