<template>
    <div class="container-fluid">
        <Spinner v-if="isLoading"/>
        <template v-else>
            <div class="row mt-2">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Levels</span>
                            <span class="info-box-number">{{ dashboardStatistics.levels }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange"><i class="fa fa-graduation-cap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Courses</span>
                            <span class="info-box-number">{{ dashboardStatistics.courses }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-green"><i class="fa fa-book-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Topics</span>
                            <span class="info-box-number">{{ dashboardStatistics.topics }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-cyan"><i class="fa fa-level-up-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Instructors</span>
                            <span class="info-box-number">{{ dashboardStatistics.instructors }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Students</span>
                            <span class="info-box-number">{{ dashboardStatistics.students }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ongoing Classes</span>
                            <span class="info-box-number">{{ dashboardStatistics.ongoingClasses }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-book-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Upcoming Classes</span>
                            <span class="info-box-number">{{ dashboardStatistics.upcomingClasses }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-book-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Exams Taken</span>
                            <span class="info-box-number">{{ dashboardStatistics.examsTaken }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    mounted() {
        this.getDashboardStatistics();
    },
    computed: {
        ...mapGetters({
            dashboardStatistics: "DASHBOARD_STATISTICS",
            isLoading: "LOADING",
        }),
    },
    methods: {
        getDashboardStatistics(){
            return this.$store.dispatch("GET_DASHBOARD_STATISTICS", {
                setsLoader: true,
            });
        }
    },
}
</script>

<style scoped>

</style>
