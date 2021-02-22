<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Code</th>
            <th>Title</th>
            <th>Duration</th>
            <th>Modules</th>
            <th>Weight</th>
            <th>Enrolled</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="course in courses">
            <td>{{course.code}}</td>
            <td>{{course.title}}</td>
            <td>{{course.duration}}</td>
            <td>{{course.numModules}}</td>
            <td>{{course.weight}}</td>
            <td>{{course.numEnrolled}}</td>
            <td>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['courses.view'])"
                        class="btn btn-sm btn-info mr-2"
                        @click="viewCourse(course)">
                    <i class="fa fa-eye"></i>
                </button>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['courses.update'])"
                        class="btn btn-sm btn-info mr-2"
                        @click="editCourse(course)">
                    <i class="fa fa-edit"></i>
                </button>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['courses.delete'])"
                        class="btn btn-sm btn-danger"
                        @click="deleteCourse(course)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                courses: 'COURSES',
            }),
        },

        methods: {
            viewCourse(course) {
                this.$store.commit('SET_ACTIVE_COURSE', course);
                this.$store.dispatch("GET_MODULES", {courseId: course.id});
            },
            editCourse(course = null) {
                EventBus.$emit('EDIT_COURSE', course);
            },

            deleteCourse(course) {
                //const index = this.courses.indexOf(course);
                //confirm('Are you sure you want to delete this item?') && this.courses.splice(index, 1);
            },
        },
    }
</script>
