<template>
    <div class="container-fluid pt-2">
        <template v-if="topic">
            <!-- Topic details -->
            <TopicDetails :course-id="courseId"  :course-title="courseTitle"/>
        </template>
        <template v-else>
            <div class="row mt-2">
                <div class="col-lg-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item" v-if="$store.getters.HAS_ANY_ACCESS(['courses.view'])">
                            <a class="nav-link" :href="'/admin/courses/' + courseId">
                                Courses Details
                            </a>
                        </li>
                        <li class="nav-item"
                            v-if="$store.getters.HAS_ANY_ACCESS(['modules','modules.view','modules.create','modules.update'])">
                            <a class="nav-link" :href="'/admin/courses/' + courseId + '/modules'">
                                Modules
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Topics</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane active">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <button v-if="$store.getters.HAS_ANY_ACCESS(['topics.create'])"
                                                @click="editTopic()"
                                                type="button"
                                                class="btn btn-sm btn-dark"
                                                data-card-widget="add"
                                                title="New Topic">
                                            <i class="fas fa-plus"></i>
                                            Add Topic
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <TopicsList/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <TopicForm :course-id="courseId" :course-title="courseTitle"/>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import TopicsList from "./TopicsList";
import TopicForm from "./TopicForm";
import TopicDetails from "./TopicDetails";

export default {
    props: {
        courseId: {
            type: String | Number,
            required: true,
            default: null
        },
        courseTitle: String,
        title: String,
    },
    components: {TopicForm, TopicsList, TopicDetails},
    computed: {
        ...mapGetters({
            isLoading: 'LOADING',
            topic: 'ACTIVE_TOPIC',
        })
    },
    created() {
        EventBus.$on("TOPIC_SAVED", this.getCourseTopics);
    },
    mounted() {
        this.getCourseTopics();
    },
    methods: {
        editTopic(topic = null) {
            EventBus.$emit("EDIT_TOPIC", topic);
        },
        async getCourseTopics() {
            try {
                await this.$store.dispatch("GET_TOPICS", {courseId: this.courseId, setsLoader: true});
            } catch (error) {
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
    },
}
</script>

<style scoped>

</style>
