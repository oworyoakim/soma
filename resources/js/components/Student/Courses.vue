<template>
    <div class="container-fluid">
        <Spinner v-if="isLoading" />
        <div class="mt-2" v-else>
            <div class="row">
                <div class="col-md-4 col-sm-6" v-for="course in myCourses">
                    <CourseCard :course="course" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import CourseCard from "./CourseCard";

export default {
    components: {CourseCard},
    props: ['title'],
    mounted() {
        this.getMyCourses();
        $( ".course-card" ).hover(
            function() {
                $(this).addClass('shadow-lg').css('cursor', 'pointer');
            }, function() {
                $(this).removeClass('shadow-lg');
            }
        );
    },
    data(){
        return {
            isLoading: false,
        }
    },
    computed: {
        ...mapGetters({
            myCourses: "MY_COURSES",
        }),
    },
    methods: {
        async getMyCourses() {
            try {
                this.isLoading = true;
                await this.$store.dispatch("GET_MY_COURSES");
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                await this.$store.dispatch("SET_SNACKBAR", {
                    message: error,
                    context: 'error'
                })
            }
        }
    },
}
</script>

<style scoped>

</style>
