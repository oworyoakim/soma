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
                <span class="info-box-icon bg-green"><i class="fa fa-book-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Exams Taken</span>
                    <span class="info-box-number">{{dashboardStatistics.examsTaken}}</span>
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
                programs: 1,
                courses: 5,
                examsTaken: 2,
                upcomingClasses: 3,
            }
        }
    },
}
</script>

<style scoped>

</style>
