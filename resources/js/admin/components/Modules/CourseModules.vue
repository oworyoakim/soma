<template>
    <div class="container-fluid pt-2">
        <template v-if="module">
            <!-- Module details -->
            <ModuleDetails :course-id="courseId" :course-title="courseTitle"/>
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
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Modules</a>
                        </li>
                        <li class="nav-item"
                            v-if="$store.getters.HAS_ANY_ACCESS(['topics','topics.view','topics.create','topics.update'])">
                            <a class="nav-link" :href="'/admin/courses/' + courseId + '/topics'">
                                Topics
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane active">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.create'])"
                                                @click="editModule()"
                                                type="button"
                                                class="btn btn-sm btn-dark"
                                                data-card-widget="add"
                                                title="New Module">
                                            <i class="fas fa-plus"></i>
                                            Add Module
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <ModulesList/>
                                </div>
                            </div>
                            <ModuleForm :course-id="courseId" :course-title="courseTitle"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ModulesList from "./ModulesList";
import ModuleForm from "./ModuleForm";
import ModuleDetails from "./ModuleDetails";

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
    components: {ModuleForm, ModulesList, ModuleDetails},
    computed: {
        ...mapGetters({
            isLoading: 'LOADING',
            module: 'ACTIVE_MODULE',
        })
    },
    created() {
        EventBus.$on("MODULE_SAVED", this.getCourseModules);
    },
    mounted() {
        this.getCourseModules();
    },
    methods: {
        editModule(module = null) {
            EventBus.$emit("EDIT_MODULE", module);
        },
        async getCourseModules() {
            try {
                await this.$store.dispatch("GET_MODULES", {courseId: this.courseId, setsLoader: true});
            } catch (error) {
                await this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
    },
}
</script>

<style scoped>

</style>
