<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <ul class="nav nav-tabs mt-0" id="classroom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="classroom-tabs-classroom-tab" data-toggle="pill"
                           href="#classroom-tabs-classroom-info"
                           role="tab" aria-controls="classroom-tabs-classroom-info" aria-selected="true">Classroom
                            Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="classroom-tabs-remarks-tab" data-toggle="pill"
                           href="#classroom-tabs-remarks" role="tab" aria-controls="classroom-tabs-remarks"
                           aria-selected="false">Remarks</a>
                    </li>
                </ul>
                <div class="tab-content mt-2" id="classroom-tabs-tabContent">
                    <div class="tab-pane fade active show" id="classroom-tabs-classroom-info" role="tabpanel"
                         aria-labelledby="classroom-tabs-classroom-tab">
                        <div class="form-group row">
                            <label class="col-md-3">Course</label>
                            <div class="col-md-9">
                                <select v-model="classroom.courseId" class="form-control" required>
                                    <option value="">Select...</option>
                                    <option v-for="course in courses" :value="course.id">{{ course.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Module</label>
                            <div class="col-md-9">
                                <select v-model="classroom.moduleId" class="form-control" required>
                                    <option value="">Select...</option>
                                    <option v-for="module in modules" :value="module.id">{{ module.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Topic</label>
                            <div class="col-md-9">
                                <select v-model="classroom.topicId" class="form-control" required>
                                    <option value="">Select...</option>
                                    <option v-for="topic in topics" :value="topic.id">{{ topic.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Title</label>
                            <div class="col-md-9">
                                <input type="text"
                                       v-model="classroom.title"
                                       class="form-control"
                                       placeholder="Title"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Start Time</label>
                            <div class="col-md-9">
                                <DateRangePicker
                                    :config="{...$store.state.dateTimeRangePickerConfig}"
                                    v-model="classroom.startTime"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Duration (in minutes)</label>
                            <div class="col-md-9">
                                <input type="number"
                                       v-model="classroom.duration"
                                       class="form-control"
                                       min="0"
                                       placeholder="Duration"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="classroom-tabs-remarks" role="tabpanel"
                         aria-labelledby="classroom-tabs-remarks-tab">
                        <div class="form-group">
                            <TinymceEditor
                                v-model="classroom.remarks"
                                :api-key="$store.getters.TINYMCE_API_KEY"
                                :init="{...$store.getters.EDITOR_CONFIG,height: 320}"
                            />
                        </div>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveClassroom()"
                    type="submit"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <Spinner v-if="isSending"/>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import {mapGetters} from "vuex";
import MainModal from "../../../shared/components/MainModal";
import Spinner from "../../../shared/components/Spinner";
import DateRangePicker from "../../../shared/components/DateRangePicker";
import {Classroom} from "../../../models/Classroom";

export default {
    created() {
        EventBus.$on(["EDIT_CLASSROOM"], this.editClassroom);
    },
    mounted() {
        this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
            options: "courses",
        });
    },
    components: {
        DateRangePicker,
        MainModal,
        Spinner,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    data() {
        return {
            classroom: new Classroom(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            formSelections: "FORM_SELECTIONS_OPTIONS",
            modules: "MODULES",
            topics: "TOPICS",
        }),
        courses() {
            return this.formSelections.courses;
        },
        title() {
            return (!!this.classroom.id) ? "Edit Live Class Schedule" : "Schedule New Live Class";
        },
        formInvalid() {
            return this.isSending || !(!!this.classroom.title && !!this.classroom.courseId && !!this.classroom.moduleId && !!this.classroom.topicId);
        }
    },
    watch: {
        "classroom.courseId"(newVal, oldVal) {
            this.getModules();
        },
        "classroom.moduleId"(newVal, oldVal) {
            this.getTopics();
        },
    },
    methods: {
        editClassroom(classroom = null) {
            this.classroom = new Classroom(classroom || {});
            this.isEditing = true;
        },
        resetForm() {
            this.classroom = new Classroom();
            this.isEditing = false;
        },
        async saveClassroom() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_CLASSROOM", this.classroom);
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("CLASSROOM_SAVED");
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        getModules() {
            if (!!this.classroom.courseId) {
                this.$store.dispatch("GET_MODULES", {courseId: this.classroom.courseId});
            }
        },
        getTopics() {
            if (!!this.classroom.moduleId) {
                this.$store.dispatch("GET_TOPICS", {moduleId: this.classroom.moduleId});
            }
        },
    }
}
</script>

<style scoped>

</style>
