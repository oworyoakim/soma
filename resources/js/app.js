import Vue from "vue";

require("./bootstrap");


import Container from "./components/Container";
import Login from "./components/Auth/Login";
import Navbar from "./components/Navbar";
import ModuleNavbar from "./components/ModuleNavbar";
import Widget from "./components/Widget";
import Toast from "./components/Toast";
import VideoPlayer from "./components/VideoPlayer";
import TextEditor from "./components/TextEditor";
//import TextEditor from "./components/RichTextEditor";
import MainModal from "./components/MainModal";
import ExamContainer from "./components/Exam/Index";
import ExamInstructions from "./components/Exam/ExamInstructions";
import ExamResults from "./components/Exam/ExamResults";
import ExamSession from "./components/Exam/ExamSession";
import QuestionForm from "./components/Courses/Admin/QuestionForm";
import AnswerForm from "./components/Courses/Admin/AnswerForm";
import Topics from "./components/Courses/Admin/Topics";
import TopicForm from "./components/Courses/Admin/TopicForm";
import Questions from "./components/Courses/Admin/Questions";
import CourseForm from "./components/Courses/Admin/CourseForm";

Vue.component("app-container", Container);
Vue.component("app-login", Login);
Vue.component("app-nav-bar", Navbar);
Vue.component("app-nav-bar-module", ModuleNavbar);
Vue.component("app-widget", Widget);
Vue.component("app-toast", Toast);
Vue.component("app-video-player", VideoPlayer);
Vue.component("app-rich-text-editor", TextEditor);
Vue.component("app-main-modal", MainModal);
Vue.component("app-exam", ExamContainer);
Vue.component("app-exam-instructions", ExamInstructions);
Vue.component("app-exam-session", ExamSession);
Vue.component("app-exam-results", ExamResults);
Vue.component("app-course-form", CourseForm);
Vue.component("app-admin-topics", Topics);
Vue.component("app-topic-form", TopicForm);
Vue.component("app-admin-questions", Questions);
Vue.component("app-question-form", QuestionForm);
Vue.component("app-answer-form", AnswerForm);

let url = document.head.querySelector('meta[name="base-url"]');
// Create an Event Bus for communications
export const EventBus = new Vue();
// base URL
export const baseUrl = url.content;
// TinyMCE API KEY
export const TinymceApiKey = "e33lp3dvbdq0nltqj3rk60z4a6teb7gnb0zvzqm8xw5kg679";
// Response Interceptor

import router from "./router";
import store from "./store";
import vuetify from "./plugins/vuetify";

const app = new Vue({
    el: "#app",
    router,
    store,
    vuetify
});
