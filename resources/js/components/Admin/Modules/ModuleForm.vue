<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">
            {{title}} ({{course.title}})
        </template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Title</label>
                    <div class="col-md-9">
                        <input type="text"
                               v-model="module.title"
                               class="form-control"
                               placeholder="Title"
                               ref="moduleTitle"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Weight (credit units)</label>
                    <div class="col-md-9">
                        <input type="number"
                               v-model="module.weight"
                               class="form-control"
                               placeholder="Weight"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Duration (in minutes)</label>
                    <div class="col-md-9">
                        <input type="number"
                               v-model="module.duration"
                               class="form-control"
                               placeholder="Duration"
                               required>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveModule()"
                    type="submit"
                    :disabled="formInvalid"
                    class="btn btn-primary btn-sm">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import MainModal from "../../Shared/MainModal";
import CourseModule from "../../../models/CourseModule";
import {mapGetters} from "vuex";

export default {
    components: {
        MainModal,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    created() {
        EventBus.$on(["EDIT_MODULE"], this.editModule);
    },
    mounted() {

    },
    computed: {
        ...mapGetters({
            course: "ACTIVE_COURSE",
        }),
        title() {
            return (!!this.module.id) ? "Edit Module" : "New Module";
        },
        formInvalid() {
            return this.isSending || !(!!this.module.title);
        },
    },
    data() {
        return {
            module: new CourseModule(),
            isEditing: false,
            isSending: false,
        }
    },
    methods: {
        async saveModule() {
            try {
                if (!this.module.courseId) {
                    this.module.courseId = this.course.id;
                }
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_MODULE", this.module);
                this.isSending = false;
                EventBus.$emit("MODULE_SAVED");
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        editModule(module = null) {
            if (!!module) {
                this.module = module;
            } else {
                this.module = new CourseModule();
            }
            this.isEditing = true;
            this.$nextTick(() => {
                this.$refs.moduleTitle.focus();
            });
        },
        resetForm() {
            this.module = new CourseModule();
            this.isEditing = false;
        }
    }
}
</script>

<style scoped>

</style>
