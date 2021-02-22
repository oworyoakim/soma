<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text"
                           v-model="topic.title"
                           ref="topicTitle"
                           class="form-control"
                           placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <TinymceEditor
                        v-model="topic.description"
                        :api-key="$store.getters.TINYMCE_API_KEY"
                        :init="{...$store.getters.EDITOR_CONFIG,height: 200}"
                        key="topic-description"
                    />
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <TinymceEditor
                        v-model="topic.body"
                        :api-key="$store.getters.TINYMCE_API_KEY"
                        :init="$store.getters.EDITOR_CONFIG"
                        key="topic-body"
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
    import Topic from "../../../models/Topic";
    import MainModal from "../../Shared/MainModal";
    import {deepClone} from "../../../utils/helpers";
    import {mapGetters} from "vuex";

    export default {
        components: {
            MainModal,
            TinymceEditor: require('@tinymce/tinymce-vue').default,
        },
        created() {
            EventBus.$on(["EDIT_TOPIC"], this.editTopic);
        },
        computed: {
            ...mapGetters({
                course: "ACTIVE_COURSE",
                module: "ACTIVE_MODULE",
            }),
            title() {
                return (!!this.topic.id) ? "Edit Topic" : "New Topic";
            },
            formInvalid() {
                return this.isSending || !(!!this.topic.title);
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
                    if (!this.topic.moduleId) {
                        this.topic.moduleId = this.module.id;
                    }
                    if (!this.topic.courseId) {
                        this.topic.courseId = this.course.id;
                    }
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_TOPIC", this.topic);
                    EventBus.$emit("TOPIC_SAVED");
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    this.resetForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
            editTopic(topic = null) {
                if (!!topic) {
                    this.topic = deepClone(topic);
                } else {
                    this.topic = new Topic();
                }
                this.isEditing = true;
                this.$nextTick(() => {
                    this.$refs.topicTitle.focus();
                });
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
