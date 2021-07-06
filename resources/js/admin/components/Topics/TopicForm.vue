<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}} - {{courseTitle}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Module</label>
                    <div class="col-md-9">
                        <select v-model="topic.moduleId" class="form-control" required>
                            <option value="">Select...</option>
                            <option v-for="module in modules" :value="module.id">
                                {{ module.title }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Title</label>
                    <div class="col-md-9">
                        <input type="text"
                               v-model="topic.title"
                               ref="topicTitle"
                               class="form-control"
                               placeholder="Title">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <TinymceEditor
                        v-model="topic.description"
                        :api-key="$store.getters.TINYMCE_API_KEY"
                        :init="{...$store.getters.EDITOR_CONFIG,height: 320}"
                        key="topic-description"
                    />
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveTopic()" type="button" :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
    import {mapGetters} from "vuex";
    import MainModal from "../../../shared/components/MainModal";
    import {Topic} from "../../../models/Topic";

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
            EventBus.$on(["EDIT_TOPIC"], this.editTopic);
        },
        mounted() {
            this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
                options: "modules",
                courseId: this.courseId,
            });
        },
        computed: {
            ...mapGetters({
                formSelections: "FORM_SELECTIONS_OPTIONS",
            }),
            modules(){
                return this.formSelections.modules;
            },
            title() {
                return (!!this.topic.id) ? "Edit Topic" : "New Topic";
            },
            formInvalid() {
                return this.isSending || !(!!this.topic.title && !!this.topic.moduleId);
            }
        },
        data() {
            return {
                topic: new Topic(),
                isEditing: false,
                isSending: false,
            }
        },
        methods: {
            async saveTopic() {
                try {
                    if (!this.topic.courseId) {
                        this.topic.courseId = this.courseId;
                    }
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_TOPIC", this.topic);
                    this.isSending = false;
                    await this.$store.dispatch("SET_SNACKBAR", {message: response});
                    this.resetForm();
                    EventBus.$emit("TOPIC_SAVED");
                } catch (error) {
                    this.isSending = false;
                    await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
            editTopic(topic = null) {
                if (!!topic) {
                    this.topic = new Topic(topic);
                } else {
                    this.topic = new Topic();
                }
                this.isEditing = true;
            },
            resetForm() {
                this.topic = new Topic();
                this.isEditing = false;
            }
        }
    }
</script>

<style scoped>

</style>
