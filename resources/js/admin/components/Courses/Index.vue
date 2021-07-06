<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else-if="course">
            <!--            Course details -->
            <CourseDetails />
        </template>
        <template v-else>
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="card-tools">
                        <button v-if="$store.getters.HAS_ANY_ACCESS(['courses.create'])"
                                @click="editCourse()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="New Course">
                            <i class="fas fa-plus"></i>
                            Add Course
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <CoursesList/>
                </div>
            </div>
            <CourseForm/>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import CoursesList from "./CoursesList";
import Spinner from "../../../shared/components/Spinner";
import CourseForm from "./CourseForm";
import CourseDetails from "./CourseDetails";
import ModulesDetails from "../Modules/ModuleDetails";
import TopicDetails from "../Topics/TopicDetails";

export default {
    props: {title: String},
    components: {
        TopicDetails,
        ModulesDetails,
        CourseDetails,
        CourseForm,
        CoursesList,
        Spinner,
    },
    created() {
        this.$store.dispatch("GET_COURSES").catch((error) => console.log(error));
    },
    computed: {
        ...mapGetters({
            course: "ACTIVE_COURSE",
            module: "ACTIVE_MODULE",
            topic: "ACTIVE_TOPIC",
            isLoading: "LOADING"
        }),
    },

    methods: {
        editCourse(course = null) {
            EventBus.$emit('EDIT_COURSE', course);
        },
    },
}
</script>

<style scoped>

</style>
