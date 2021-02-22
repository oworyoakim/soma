<template>
<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Programs</span>
                    <span class="info-box-number">{{dashboardStatistics.programs}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-book-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Courses</span>
                    <span class="info-box-number">{{dashboardStatistics.courses}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-cyan"><i class="fa fa-level-up-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Instructors</span>
                    <span class="info-box-number">{{dashboardStatistics.instructors}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Students</span>
                    <span class="info-box-number">{{dashboardStatistics.students}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-book-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Exams Taken</span>
                    <span class="info-box-number">{{dashboardStatistics.examsTaken}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-warning"><i class="fa fa-book-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ongoing Classes</span>
                    <span class="info-box-number">{{dashboardStatistics.ongoingClasses}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-book-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Upcoming Classes</span>
                    <span class="info-box-number">{{dashboardStatistics.upcomingClasses}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-gradient-green"><i class="fa fa-graduation-cap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Graduands</span>
                    <span class="info-box-number">{{dashboardStatistics.graduands}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <EventsCalendar />
        </div>
    </div>
</div>
</template>

<script>
import EventsCalendar from "../Shared/EventsCalendar";
export default {
    components: {
        EventsCalendar,
    },
    data(){
        return {
            dashboardStatistics: {
                programs: 21,
                courses: 113,
                instructors: 17,
                students: 1230,
                examsTaken: 405,
                ongoingClasses: 6,
                upcomingClasses: 56,
                graduands: 2342,
            }
        }
    },
}
</script>

<style scoped>

</style>
