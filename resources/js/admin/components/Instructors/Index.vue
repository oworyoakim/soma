<template>
    <div class="container-fluid  pt-2">
        <template v-if="isLoading">
            <Spinner/>
        </template>
        <template v-else-if="activeInstructor">
            <InstructorDetails/>
        </template>
        <template v-else-if="instructorsInfo">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="card-tools">
                        <button :disabled="isLoading" @click="editInstructor()" class="btn btn-dark btn-sm">
                            <i class="fas fa-plus"></i> New Instructor
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <InstructorsList/>
                </div>
                <div class="card-footer">
                    <Pagination :items="instructorsInfo" @gotoPage="getInstructors"/>
                </div>
            </div>
            <InstructorForm/>
        </template>
        <template v-else>
            <h3>No data!</h3>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import InstructorsList from "./InstructorsList";
import InstructorDetails from "./InstructorDetails";
import InstructorForm from "./InstructorForm";
import Pagination from "../../../shared/components/Pagination";

export default {
    components: {Pagination, InstructorsList, InstructorDetails, InstructorForm},
    created() {
        // get instructors here
        this.getInstructors();
        EventBus.$on('DELETE_INSTRUCTOR', this.deleteInstructor);
        EventBus.$on(['INSTRUCTOR_SAVED'], this.getInstructors);
    },
    data() {
        return {
            page: 1,
            isLoading: false,
        }
    },
    computed: {
        ...mapGetters({
            instructorsInfo: "INSTRUCTORS",
            activeInstructor: "ACTIVE_INSTRUCTOR",
        }),
    },
    methods: {
        editInstructor(instructor = null) {
            EventBus.$emit('EDIT_INSTRUCTOR', instructor);
        },
        async getInstructors(page = 0) {
            try {
                if (page > 0) {
                    this.page = page;
                }
                this.isLoading = true;
                await this.$store.dispatch("GET_INSTRUCTORS", {page: this.page});
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },

        async deleteInstructor(instructor) {

        },
    },
}
</script>

<style scoped>

</style>
