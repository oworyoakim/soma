<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else-if="enrollmentsInfo">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="card-tools">
                        <button @click="editEnrollment()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="New Enrollment">
                            <i class="fas fa-plus"></i>
                            Enroll Learner
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <EnrollmentsList/>
                </div>
                <div class="card-footer">
                    <Pagination :items="enrollmentsInfo" @gotoPage="getEnrollments"/>
                </div>
            </div>
            <EnrollmentForm />
        </template>
        <template v-else>
            <h3>No data!</h3>
        </template>
    </div>
</template>

<script>
    import EnrollmentForm from "./EnrollmentForm";
    import EnrollmentsList from "./EnrollmentsList";
    import Pagination from "../../../shared/components/Pagination";
    import {mapGetters} from "vuex";
    export default {
        props: ['title'],
        components: {Pagination, EnrollmentsList, EnrollmentForm},
        created() {
            EventBus.$on(['ENROLLMENT_SAVED'], () => {
                this.getEnrollments();
            });
        },
        mounted() {
            this.getEnrollments().then(()=>{
                this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
                    options: "students,courses",
                });
            }).catch((error) => {
                console.log(error);
            });
        },
        computed: {
            ...mapGetters({
                enrollmentsInfo: "ENROLLMENTS",
            }),
        },
        data(){
            return {
                isLoading: false,
                page: 1,
            }
        },
        methods: {
            editEnrollment(enrollment = null){
                EventBus.$emit("EDIT_ENROLLMENT", enrollment);
            },
            async getEnrollments(page = 0) {
                try {
                    if(page > 0){
                        this.page = page;
                    }
                    this.isLoading = true;
                    await this.$store.dispatch("GET_ENROLLMENTS", {page: this.page});
                    this.isLoading = false;
                } catch (error) {
                    this.isLoading = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
        },
    }
</script>

<style scoped>

</style>
