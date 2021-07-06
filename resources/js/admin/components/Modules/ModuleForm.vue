<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">
            {{ courseTitle }} Module Form
        </template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text"
                           v-model="module.title"
                           class="form-control"
                           placeholder="Title"
                           ref="moduleTitle"
                           required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <TinymceEditor
                        v-model="module.description"
                        :api-key="$store.getters.TINYMCE_API_KEY"
                        :init="{...$store.getters.EDITOR_CONFIG}"
                    />
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
import {mapGetters} from "vuex";
import MainModal from "../../../shared/components/MainModal";
import {CourseModule} from "../../../models/CourseModule";

export default {
    props: {
        courseId: {
            type: String | Number,
            required: true,
            default: null
        },
        courseTitle: String,
    },
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
        formInvalid() {
            return this.isSending || !this.module || !(!!this.module.title);
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
                    this.module.courseId = this.courseId;
                }
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_MODULE", this.module);
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: response});
                this.resetForm();
                EventBus.$emit("MODULE_SAVED");
            } catch (error) {
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        editModule(module = null) {
            this.module = new CourseModule(module || {courseId: this.courseId});
            this.isEditing = true;
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
