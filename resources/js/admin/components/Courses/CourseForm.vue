<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Level</label>
                    <div class="col-md-9">
                        <select v-model="learningPathId" class="form-control" required>
                            <option value="">Select...</option>
                            <option v-for="learningPath in learningPaths" :value="learningPath.id">{{ learningPath.title }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Sub Level</label>
                    <div class="col-md-9">
                        <select v-model="course.levelId" class="form-control" required>
                            <option value="">Select...</option>
                            <option v-for="level in levels" :value="level.id">{{ level.title }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Title</label>
                    <div class="col-md-9">
                        <input type="text"
                               v-model="course.title"
                               class="form-control"
                               placeholder="Title"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Code</label>
                    <div class="col-md-9">
                        <input type="text"
                               v-model="course.code"
                               class="form-control"
                               placeholder="Code"
                               required>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveCourse()"
                    type="submit"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import MainModal from "../../../shared/components/MainModal";
import {deepClone} from "../../../shared/utils/helpers";
import {mapGetters} from "vuex";
import {Course} from "../../../models/Course";

export default {
    created() {
        EventBus.$on(["EDIT_COURSE"], this.editCourse);
    },
    mounted() {
        this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
            options: "levels,learningPaths",
            learningPathId: this.learningPathId
        });
    },
    components: {
        MainModal,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    data() {
        return {
            learningPathId: '',
            course: new Course(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            formSelections: "FORM_SELECTIONS_OPTIONS",
        }),
        learningPaths() {
            return this.formSelections.learningPaths;
        },
        levels() {
            return this.formSelections.levels.filter((level) => level.learningPathId === this.learningPathId);
        },
        title() {
            return (!!this.course.id) ? "Edit Course" : "New Course";
        },
        formInvalid() {
            return this.isSending || !(!!this.course.title && !!this.course.levelId && !!this.course.code);
        }
    },
    watch: {
        learningPathId(newVal, oldVal){
            // this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
            //     options: "levels,learningPaths",
            //     learningPathId: this.learningPathId
            // });
        }
    },
    methods: {
        editCourse(course = null) {
            this.course = new Course(course || {});
            let level = this.formSelections.levels.find((level) => level.id === this.course.id);
            if(level) {
                let learningPath = this.learningPaths.find((path) => path.id === level.learningPathId);
                if (learningPath) {
                    this.learningPathId = learningPath.id;
                }
            }
            this.isEditing = true;
        },
        resetForm() {
            this.course = new Course();
            this.isEditing = false;
        },
        async saveCourse() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_COURSE", this.course);
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("COURSE_SAVED");
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
    }
}
</script>

<style scoped>

</style>
