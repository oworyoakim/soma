<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <ul class="nav nav-tabs mt-0" id="program-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="program-tabs-program-tab" data-toggle="pill"
                           href="#program-tabs-program"
                           role="tab" aria-controls="program-tabs-program" aria-selected="true">Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="program-tabs-description-tab" data-toggle="pill"
                           href="#program-tabs-description" role="tab" aria-controls="program-tabs-description"
                           aria-selected="false">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="program-tabs-requirements-tab" data-toggle="pill"
                           href="#program-tabs-requirements" role="tab" aria-controls="program-tabs-requirements"
                           aria-selected="false">Requirements</a>
                    </li>
                </ul>
                <div class="tab-content mt-2" id="program-tabs-tabContent">
                    <div class="tab-pane fade active show" id="program-tabs-program" role="tabpanel"
                         aria-labelledby="program-tabs-program-tab">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Title</label>
                                <input type="text"
                                       v-model="program.title"
                                       class="form-control"
                                       placeholder="Title"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label>Duration (in months)</label>
                                <input type="number"
                                       v-model="program.duration"
                                       class="form-control"
                                       placeholder="Duration"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Age Limit</label>
                                <input type="number"
                                       v-model="program.ageLimit"
                                       class="form-control"
                                       placeholder="Pass Mark"
                                       min="0"
                                       max="100"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label>Pass Mark (in %age)</label>
                                <input type="number"
                                       v-model="program.passMark"
                                       class="form-control"
                                       placeholder="Pass Mark"
                                       min="0"
                                       max="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Prerequisites</label>
                                <div class="form-check">
                                    <template v-for="prerequisite in prerequisites">
                                        <p class="form-check-label">
                                            <input type="checkbox" class="form-check-input"
                                                   v-model="program.prerequisiteIds"
                                                   :value="prerequisite.id">
                                            {{ prerequisite.title }}
                                        </p>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Courses</label>
                                <div class="form-check">
                                    <template v-for="course in courses">
                                        <p class="form-check-label">
                                            <input type="checkbox" class="form-check-input" v-model="program.courseIds"
                                                   :value="course.id">
                                            {{ course.title }}
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="program-tabs-description" role="tabpanel"
                         aria-labelledby="program-tabs-description-tab">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Description</label>
                                <TinymceEditor
                                    v-model="program.description"
                                    :api-key="$store.getters.TINYMCE_API_KEY"
                                    :init="{...$store.getters.EDITOR_CONFIG,height: 480}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="program-tabs-requirements" role="tabpanel"
                         aria-labelledby="program-tabs-requirements-tab">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Requirements</label>
                                <TinymceEditor
                                    v-model="program.requirements"
                                    :api-key="$store.getters.TINYMCE_API_KEY"
                                    :init="{...$store.getters.EDITOR_CONFIG,height: 480}"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveProgram()"
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
import MainModal from "../../Shared/FullscreenModal";
import {deepClone} from "../../../utils/helpers";
import Program from "../../../models/Program";
import {mapGetters} from "vuex";

export default {
    components: {
        MainModal,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    created() {
        EventBus.$on('EDIT_PROGRAM', this.editProgram);
    },
    mounted() {
        this.$store.dispatch('GET_FORM_SELECTIONS_OPTIONS');
    },
    data() {
        return {
            program: new Program(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            formSelections: 'FORM_SELECTIONS_OPTIONS',
        }),
        courses() {
            return this.formSelections.courses;
        },
        prerequisites() {
            return this.formSelections.programs.filter((program) => program.id !== this.program.id);
        },
        title() {
            return (!!this.program.id) ? "Edit Program" : "Create Program";
        },
        formInvalid() {
            return this.isSending;
        }
    },
    methods: {
        editProgram(program = null) {
            if (program) {
                this.program = deepClone(program);
            } else {
                this.program = new Program();
            }
            this.isEditing = true;
        },
        async saveProgram() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch('SAVE_PROGRAM', this.program);
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("PROGRAM_SAVED");
                this.isSending = false;
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.program = new Program();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
