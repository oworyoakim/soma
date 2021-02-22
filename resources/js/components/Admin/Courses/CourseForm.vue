<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Level</label>
                    <div class="col-md-9">
                        <select v-model="course.levelId" class="form-control" required>
                            <option value="">Select...</option>
                            <option v-for="level in levels" :value="level.id">{{level.title}}</option>
                        </select>
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
                    <label class="col-md-3">Duration (in minutes)</label>
                    <div class="col-md-9">
                        <input type="number"
                               v-model="course.duration"
                               class="form-control"
                               placeholder="Duration"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Weight (credit units)</label>
                    <div class="col-md-9">
                        <input type="number"
                               v-model="course.weight"
                               class="form-control"
                               placeholder="Weight"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12">Programs</label>
                    <div class="col-md-12 form-check ml-4">
                        <template v-for="program in programs">
                            <p class="form-check-label">
                                <input type="checkbox" class="form-check-input" v-model="course.programIds" :value="program.id">
                                {{program.title}}
                            </p>
                        </template>
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
    import MainModal from "../../Shared/MainModal";
    import Course from "../../../models/Course";
    import {deepClone} from "../../../utils/helpers";
    import {mapGetters} from "vuex";

    export default {
        created() {
            EventBus.$on(["EDIT_COURSE"], this.editCourse);
        },
        mounted() {
            this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS");
        },
        components: {
            MainModal,
            TinymceEditor: require('@tinymce/tinymce-vue').default,
        },
        data() {
            return {
                course: new Course(),
                isEditing: false,
                isSending: false,
            }
        },
        computed: {
            ...mapGetters({
                levels: "LEVELS",
                formSelections: "FORM_SELECTIONS_OPTIONS",
            }),
            programs(){
                return this.formSelections.programs;
            },
            title(){
                return (!!this.course.id) ? "Edit Course" : "New Course";
            },
            formInvalid(){
                return this.isSending || !(!!this.course.title && !!this.course.levelId && !!this.course.code);
            }
        },
        methods: {
            editCourse(course = null) {
                if (course) {
                    this.course = deepClone(course);
                } else {
                    this.course = new Course();
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
                    this.$store.dispatch("SET_SNACKBAR",{message: response});
                    EventBus.$emit("COURSE_SAVED");
                    this.resetForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{message: error,context: 'error'});
                }
            },
        }
    }
</script>

<style scoped>

</style>
