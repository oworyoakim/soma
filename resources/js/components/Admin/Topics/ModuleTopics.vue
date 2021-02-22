<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-tools">
                <template v-if="isEditingTopic">
                    <button type="button"
                            class="btn btn-secondary btn-sm mr-2"
                            @click="resetForm()">
                        Cancel
                    </button>
                    <button @click="saveTopic()" type="button" :disabled="formInvalid"
                            class="btn btn-primary btn-sm float-right">
                        <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                        <span v-else>Submit</span>
                    </button>
                </template>
                <template v-else>
                    <button type="button"
                            class="btn btn-sm btn-dark"
                            data-card-widget="add"
                            @click="editTopic()"
                            title="New Topic">
                        <i class="fas fa-plus"></i>
                        Add Topic
                    </button>
                </template>
            </div>
        </div>
        <div class="card-body table-responsive">
            <template v-if="isEditingTopic">
                <form autocomplete="off" novalidate>
                    <div class="form-group">
                        <h3 class="text-bold">Title</h3>
                        <input type="text" v-model="topic.title" class="form-control" placeholder="Title">
                    </div>
                    <div class="form-group mt-2">
                        <h3 class="text-bold">Description</h3>
                        <TinymceEditor
                            v-model="topic.description"
                            :api-key="$store.getters.TINYMCE_API_KEY"
                            :init="$store.getters.EDITOR_CONFIG"
                            key="topic-description"
                        />
                    </div>
                    <div class="form-group mt-2">
                        <h3 class="text-bold">Body</h3>
                        <TinymceEditor
                            v-model="topic.body"
                            :api-key="$store.getters.TINYMCE_API_KEY"
                            :init="$store.getters.EDITOR_CONFIG"
                            key="topic-body"
                        />
                    </div>
                </form>
            </template>
            <template v-else>
                <TopicsList @edit-topic="editTopic"/>
            </template>
        </div>
    </div>
</template>

<script>
    import TopicsList from "./TopicsList";
    import TopicForm from "./TopicForm";
    import Topic from "../../../models/Topic";
    import {deepClone} from "../../../utils/helpers";
    import {mapGetters} from "vuex";

    export default {
        components: {
            TopicForm,
            TopicsList,
            TinymceEditor: require('@tinymce/tinymce-vue').default,
        },
        data() {
            return {
                topic: new Topic(),
                isEditingTopic: false,
                isSending: false,
            }
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
        methods: {
            editTopic(topic = null) {
                if (topic) {
                    this.topic = deepClone(topic);
                } else {
                    this.topic = new Topic();
                }
                this.isEditingTopic = true;
            },
            resetForm() {
                this.topic = new Topic();
                this.isEditingTopic = false;
            },
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
        },
    }
</script>

<style scoped>

</style>
