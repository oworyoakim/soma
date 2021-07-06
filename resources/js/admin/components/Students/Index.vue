<template>
    <div class="container-fluid  pt-2">
        <template v-if="isLoading">
            <Spinner/>
        </template>
        <template v-else-if="activeStudent">
            <StudentDetails/>
        </template>
        <template v-else-if="studentsInfo">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="card-tools">
                        <button v-if="$store.getters.HAS_ANY_ACCESS(['students.create'])" :disabled="isLoading" @click="editStudent()" class="btn btn-dark btn-sm">
                            <i class="fas fa-plus"></i> New Student
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <StudentsList/>
                </div>
                <div class="card-footer">
                    <Pagination :items="studentsInfo" @gotoPage="getStudents"/>
                </div>
            </div>
            <StudentForm/>
        </template>
        <template v-else>
            <h3>No data!</h3>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import StudentsList from "./StudentsList";
import StudentDetails from "./StudentDetails";
import StudentForm from "./StudentForm";
import Pagination from "../../../shared/components/Pagination";

export default {
    components: {Pagination, StudentsList, StudentDetails, StudentForm},
    created() {
        // get students here
        this.getStudents();
        EventBus.$on('DELETE_STUDENT', this.deleteStudent);
        EventBus.$on(['STUDENT_SAVED'], this.getStudents);
    },
    data() {
        return {
            page: 1,
            isLoading: false,
        }
    },
    computed: {
        ...mapGetters({
            studentsInfo: "STUDENTS",
            activeStudent: "ACTIVE_STUDENT",
        }),
    },
    methods: {
        editStudent(student = null) {
            EventBus.$emit('EDIT_STUDENT', student);
        },
        async getStudents(page = 0) {
            try {
                if (page > 0) {
                    this.page = page;
                }
                this.isLoading = true;
                await this.$store.dispatch("GET_STUDENTS", {page: this.page});
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },

        async deleteStudent(student) {

        },
    },
}
</script>

<style scoped>

</style>
