<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading || !course"/>
        <template v-else>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" @click="editCourseDescription(false)" href="#course_description">
                                Description
                            </a>
                        </li>
                        <li class="nav-item"
                            v-if="$store.getters.HAS_ANY_ACCESS(['modules','modules.view','modules.create','modules.update','topics','topics.view','topics.create','topics.update'])">
                            <a class="nav-link" @click="editCourseDescription(false)"
                               :href="'/admin/courses/' + course.id + '/modules'">
                                Modules
                            </a>
                        </li>
                        <li class="nav-item"
                            v-if="$store.getters.HAS_ANY_ACCESS(['topics','topics.view','topics.create','topics.update'])">
                            <a class="nav-link" @click="editCourseDescription(false)"
                               :href="'/admin/courses/' + course.id + '/topics'">
                                Topics
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane active" id="course_description">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-bold">{{ course.title }} ({{ course.code }})</h3>
                                    <div class="card-tools">
                                        <template v-if="isEditingDescription">
                                            <button @click="editCourseDescription(false)"
                                                    type="button"
                                                    class="btn btn-dark btn-sm mr-2">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                    @click="updateCourseDescription()"
                                                    :disabled="isSending || courseDescription === course.description"
                                                    class="btn btn-primary btn-sm">
                                                Save
                                            </button>
                                        </template>
                                        <template v-else>
                                            <a href="/admin/courses" class="btn btn-dark btn-sm mr-5">
                                                <i class="fa fa-backward"></i>
                                                Back To Courses
                                            </a>
                                            <button v-if="$store.getters.HAS_ANY_ACCESS(['courses.update'])"
                                                    @click="editCourseDescription()"
                                                    :disabled="isEditingDescription"
                                                    class="btn btn-info btn-sm float-right">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <div v-if="isEditingDescription" class="card-body">
                                    <div class="form-group">
                                        <TinymceEditor
                                            v-model="courseDescription"
                                            :api-key="$store.getters.TINYMCE_API_KEY"
                                            :init="{...$store.getters.EDITOR_CONFIG,height: 600}"
                                        />
                                    </div>
                                </div>
                                <div v-else class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body widget about-widget custom-about mb-0">
                                                <h2 class="widget-title text-decoration-underline">Course Description</h2>
                                                <hr />
                                                <div class="mt-0" v-html="course.description"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <PreviewExam/>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ModuleForm from "../Modules/ModuleForm";
import CourseModules from "../Modules/CourseModules";
import TopicForm from "../Topics/TopicForm";
import PreviewExam from "../Exams/PreviewExam";

export default {
    props: {
        courseId: {
            type: String | Number,
            required: true,
            default: null
        },
        title: String,
    },
    components: {
        PreviewExam,
        CourseModules,
        ModuleForm,
        TopicForm,
        TinymceEditor: require('@tinymce/tinymce-vue').default
    },
    computed: {
        ...mapGetters({
            isLoading: "LOADING",
            course: "ACTIVE_COURSE",
        }),
    },
    mounted() {
        this.getCourseDetails();
    },
    data() {
        return {
            courseDescription: null,
            isEditingDescription: false,
            isSending: false,
        }
    },
    methods: {
        async getCourseDetails() {
            try {
                await this.$store.dispatch("GET_COURSE_DETAILS", {courseId: this.courseId, setsLoader: true});
            } catch (error) {
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        viewModule(module) {
            this.$store.dispatch("SET_ACTIVE_MODULE", module);
        },
        previewCourseExam() {
            EventBus.$emit("PREVIEW_EXAM", {slug: this.course.slug})
        },
        backToCourses() {
            this.editCourseDescription(false);
            this.$store.commit('SET_ACTIVE_COURSE', null);
        },
        editCourseDescription(editing = true) {
            if (editing) {
                this.courseDescription = this.course.description;
                this.isEditingDescription = true;
            } else {
                this.isEditingDescription = false;
                this.courseDescription = null;
            }
        },
        async updateCourseDescription() {
            try {
                let course = {
                    id: this.course.id,
                    description: this.courseDescription,
                };
                this.isSending = true;
                let response = await this.$store.dispatch("UPDATE_COURSE_DESCRIPTION", course);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                let newCourse = this.deepClone(this.course);
                newCourse.description = course.description;
                this.$store.commit("SET_ACTIVE_COURSE", newCourse);
                this.editCourseDescription(false);
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        }
    },
    created() {
        EventBus.$on("MODULE_SAVED", () => {
            this.$store.dispatch("GET_MODULES", {courseId: this.course.id});
        });
    },
}
</script>

<style scoped>
.course-details {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
