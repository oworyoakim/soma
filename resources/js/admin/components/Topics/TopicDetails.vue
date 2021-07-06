<template>
    <div class="module-details mt-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">
                    Topic Details (<small>{{title}}</small>)
                </h3>
                <div class="card-tools">
                    <button @click="backToTopics()" class="btn btn-dark btn-sm float-right">
                        <i class="fa fa-backward"></i>
                        Back To Topics
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active"
                           @click="disabledEditing()"
                           href="#topic_description"
                           data-toggle="tab">
                            Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           @click="disabledEditing()"
                           href="#topic_body"
                           data-toggle="tab">
                            Content
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           :disabled="isOnLiveScreen"
                           @click="disabledEditing('topic_live')"
                           href="#topic_live"
                           data-toggle="tab">
                            Live
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           @click="disabledEditing()"
                           href="#topic_questions"
                           data-toggle="tab">
                            Questions
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2">
                    <div class="tab-pane active" id="topic_description">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools">
                                    <template v-if="isEditingDescription">
                                        <button @click="editTopicDescription(false)"
                                                type="button"
                                                class="btn btn-dark btn-sm mr-2">
                                            Cancel
                                        </button>
                                        <button type="button" @click="updateDescription()"
                                                :disabled="isSending || topicDescription === topic.description"
                                                class="btn btn-primary btn-sm">
                                            Save
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click="editTopicDescription()"
                                                :disabled="isEditingDescription"
                                                class="btn btn-info btn-sm float-right">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div v-if="isEditingDescription" class="card-body">
                                <div class="form-group">
                                    <TinymceEditor
                                        v-model="topicDescription"
                                        :api-key="$store.getters.TINYMCE_API_KEY"
                                        :init="{...$store.getters.EDITOR_CONFIG,height: 600}"
                                    />
                                </div>
                            </div>
                            <div v-else class="card-body" v-html="topic.description"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="topic_body">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools">
                                    <template v-if="isEditingBody">
                                        <button @click="editTopicBody(false)"
                                                type="button"
                                                class="btn btn-dark btn-sm mr-2">
                                            Cancel
                                        </button>
                                        <button type="button" @click="updateBody()"
                                                :disabled="isSending || topicBody === topic.body"
                                                class="btn btn-primary btn-sm">
                                            Save
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click="editTopicBody()"
                                                :disabled="isEditingBody"
                                                class="btn btn-info btn-sm float-right">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div v-if="isEditingBody" class="card-body">
                                <div class="form-group">
                                    <TinymceEditor
                                        v-model="topicBody"
                                        :api-key="$store.getters.TINYMCE_API_KEY"
                                        :init="{...$store.getters.EDITOR_CONFIG,height: 600}"
                                    />
                                </div>
                            </div>
                            <div v-else class="card-body" v-html="topic.body"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="topic_live">
                        <template v-if="isOnLiveScreen">
                            <template v-if="!!classroom">
                                <ZoomFrame :classroom-id="classroom.id" />
                            </template>
                            <template v-else>
                                <h3 class="text-danger">No active classroom for this topic!</h3>
                            </template>
                        </template>
                    </div>
                    <div class="tab-pane" id="topic_questions">
                        <Questions :questions.sync="topic.questions" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import Questions from "../Questions/IndexQuestions";
    import ZoomFrame from "../../../shared/components/ZoomFrame";

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
            ZoomFrame,
            Questions,
            TinymceEditor: require('@tinymce/tinymce-vue').default,
        },
        computed: {
            ...mapGetters({
                topic: "ACTIVE_TOPIC",
            }),
            classroom(){
                if(this.topic){
                    return this.topic.classroom || null;
                }
                 return null;
            },
            height(){
                return (window.innerHeight * 0.75) + 2;
            },
            title(){
                if(!this.topic){
                    return '';
                }
                if(this.topic.module){
                    if(this.topic.module.course){
                        return this.topic.module.course.title + " / " + this.topic.module.title + " / " + this.topic.title;
                    }
                    return this.topic.module.title + " / " + this.topic.title;
                }
                return this.topic.title;
            },
        },
        data() {
            return {
                topicDescription: null,
                topicBody: null,
                isSending: false,
                isEditingDescription: false,
                isEditingBody: false,
                isOnLiveScreen: false,
            }
        },
        created() {
            EventBus.$on(["TOPIC_SAVED","QUESTION_SAVED"], () => {
                this.$store.dispatch("GET_TOPIC_DETAILS", {topicId: this.topic.id});
            });
        },
        methods: {
            backToTopics() {
                this.$store.commit("SET_ACTIVE_TOPIC", null);
            },
            disabledEditing(activeTab = ''){
                this.editTopicDescription(false);
                this.editTopicBody(false);
                if(this.isOnLiveScreen){
                    this.isOnLiveScreen = false;
                }else if(activeTab === 'topic_live'){
                    this.isOnLiveScreen = true;
                }
            },
            editTopicDescription(editing = true) {
                if (editing) {
                    this.topicDescription = this.topic.description;
                    this.isEditingDescription = true;
                } else {
                    this.isEditingDescription = false;
                    this.topicDescription = null;
                }
            },
            editTopicBody(editing = true) {
                if (editing) {
                    this.topicBody = this.topic.body;
                    this.isEditingBody = true;
                } else {
                    this.isEditingBody = false;
                    this.topicBody = null;
                }
            },
            async updateDescription() {
                try {
                    let topic = {
                        id: this.topic.id,
                        description: this.topicDescription,
                    };
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_TOPIC", topic);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    EventBus.$emit("TOPIC_SAVED");
                    this.editTopicDescription(false);
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
            async updateBody() {
                try {
                    let topic = {
                        id: this.topic.id,
                        body: this.topicBody,
                    };
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_TOPIC", topic);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    EventBus.$emit("TOPIC_SAVED");
                    this.editTopicBody(false);
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
