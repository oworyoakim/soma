<template>
    <MainModal v-if="isEditing" @closed="resetForm()" @submitted="this.saveExam">
        <template slot="header">{{ title }}</template>
        <template slot="body">
                <ul class="nav nav-tabs mt-0" id="exam-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="exam-tabs-exam-tab" data-toggle="pill"
                           href="#exam-tabs-exam-info"
                           role="tab" aria-controls="exam-tabs-exam-info" aria-selected="true">Exam Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="exam-tabs-questions-tab" data-toggle="pill"
                           href="#exam-tabs-questions" role="tab" aria-controls="exam-tabs-questions"
                           aria-selected="false">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="exam-tabs-instructions-tab" data-toggle="pill"
                           href="#exam-tabs-instructions" role="tab" aria-controls="exam-tabs-instructions"
                           aria-selected="false">Instructions</a>
                    </li>
                </ul>
                <div class="tab-content mt-2" id="exam-tabs-tabContent">
                    <div class="tab-pane fade active show" id="exam-tabs-exam-info" role="tabpanel"
                         aria-labelledby="exam-tabs-exam-tab">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="code">Exam Code</label>
                                <input type="text" id="code" class="form-control"
                                       v-model="exam.code"
                                       required>
                            </div>
                            <div class="col-sm-6">
                                <label for="duration">Duration (in minutes)</label>
                                <input id="duration" class="form-control"
                                       v-model="exam.duration"
                                       type="number"
                                       min="0"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="passScore">Pass score (in %age)</label>
                                <input id="passScore" class="form-control"
                                       v-model="exam.passMark"
                                       type="number"
                                       min="0"
                                       max="100"
                                       required>
                            </div>
                            <div class="col-sm-6">
                                <label for="maximumAttempts">Maximum attempts on this exam by a student</label>
                                <input id="maximumAttempts" class="form-control"
                                       v-model="exam.maximumAttempts"
                                       type="number"
                                       min="0"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row" v-if="!exam.id">
                            <div class="col-sm-6">
                                <label for="programId">Program</label>
                                <select id="programId" class="form-control"
                                        v-model="exam.programId"
                                        required>
                                    <option value=""></option>
                                    <option v-for="program in programs" :value="program.id" :key="program.id">
                                        {{ program.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="courseId">Course</label>
                                <select id="courseId" class="form-control"
                                        v-model="exam.courseId"
                                        required>
                                    <option value=""></option>
                                    <option v-for="course in courses" :value="course.id" :key="course.id">
                                        {{ course.title }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="intakeId">Intake</label>
                                <select id="intakeId" class="form-control"
                                        v-model="exam.intakeId"
                                        required>
                                    <option value=""></option>
                                    <option v-for="intake in intakes" :value="intake.id" :key="intake.id">
                                        {{ intake.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="levelId">Level</label>
                                <select id="levelId" class="form-control"
                                        v-model="exam.levelId"
                                        required>
                                    <option value=""></option>
                                    <option v-for="level in levels" :value="level.id" :key="level.id">
                                        {{ level.title }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="exam-tabs-questions" role="tabpanel"
                         aria-labelledby="exam-tabs-questions-tab">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="numQuestions">Number of questions to be attempted</label>
                                <input id="numQuestions" class="form-control"
                                       v-model="exam.numberOfQuestions"
                                       type="number"
                                       min="0"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label class="text-underline">Number of questions per Module</label>
                            </div>
                            <div class="col-sm-12">
                                <div class="row my-1" v-for="module in exam.modules">
                                    <div class="col-6 text-bold">{{ module.title }} (<small class="text-muted">available: {{module.maxNumQuestions}}</small>)</div>
                                    <div class="col-6">
                                        <input type="number"
                                               class="form-control"
                                               v-model="module.numQuestions"
                                               min="0"
                                               :max="module.maxNumQuestions"
                                               placeholder="Number of questions">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="exam-tabs-instructions" role="tabpanel"
                         aria-labelledby="exam-tabs-instructions-tab">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label class="font-weight-bold">Instructions</label>
                                <TinymceEditor
                                    v-model="exam.instructions"
                                    :api-key="$store.getters.TINYMCE_API_KEY"
                                    :init="{...$store.getters.EDITOR_CONFIG, height: 400}"
                                />
                            </div>
                        </div>
                    </div>
                </div>
        </template>
        <template slot="footer">
            <button type="submit"
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
import MainModal from "../../Shared/MainModal";
import {deepClone} from "../../../utils/helpers";
import Exam from "../../../models/Exam";

export default {
    created() {
        EventBus.$on('EDIT_EXAM', this.editExam);
    },
    components: {
        MainModal,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    computed: {
        ...mapGetters({
            selectionsOptions: 'FORM_SELECTIONS_OPTIONS',
        }),
        intakes() {
            return this.selectionsOptions.intakes;
        },
        levels() {
            return this.selectionsOptions.levels;
        },
        programs() {
            return this.selectionsOptions.programs;
        },
        courses() {
            return this.selectionsOptions.courses.filter((course) => {
                let program = this.programs.find((program) => program.id === this.exam.programId);
                let programCourseIds = !!program ? program.courseIds : [];
                return programCourseIds.includes(course.id);
            });
        },
        title() {
            return (!!this.exam.id) ? "Edit Exam" : "New Exam";
        },
        formInvalid() {
            return this.isSending || !(!!this.exam.code && !!this.exam.intakeId && !!this.exam.courseId && !!this.exam.programId && !!this.exam.numberOfQuestions && this.examNumberOfQuestions === this.numQuestions);
        },
        examNumberOfQuestions(){
            return this.$numeral(this.exam.numberOfQuestions).value();
        },
        numQuestions() {
            return this.exam.modules.reduce((count, module) => {
                return count + Number(module.numQuestions);
            }, 0);
        },
    },
    data() {
        return {
            exam: new Exam(),
            isEditing: false,
            isSending: false,
        }
    },
    watch: {
        "exam.courseId"(newVal, oldVal) {
            this.getModules();
        },
    },
    methods: {
        editExam(exam = null) {
            if (exam) {
                this.exam = deepClone(exam);
            } else {
                this.exam = new Exam();
            }
            this.isEditing = true;
        },
        resetForm() {
            this.exam = new Exam();
            this.isEditing = false;
        },
        async getModules() {
            try {
                if (!!!this.exam.id && !!this.exam.courseId) {
                    this.exam.modules = await this.$store.dispatch("GET_MODULES", {courseId: this.exam.courseId});
                }
            } catch (error) {
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        async saveExam() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_EXAM", this.exam);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("EXAM_SAVED");
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
    }
}
</script>

<style scoped>
/* Underline text */
.text-underline {
    text-decoration: underline !important;
}
</style>
