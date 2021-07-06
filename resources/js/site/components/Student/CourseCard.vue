<template>
    <div class="card course-card my-2" @click="readCourse()">
        <div class="card-body">
            <h4 class="card-title text-bold text-center">{{ course.title }}</h4>
            <div class="card-text course-description mt-2" v-html="stringLimit(course.description, 200)"></div>
            <a href="#" class="btn btn-info mt-2">Explore</a>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    methods: {
        readCourse() {
            console.log("Reading course: ", this.course);
        }
    },
}
</script>

<style scoped>
    .course-card:hover {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    .course-description {
        font-size: 10pt !important;
    }
</style>
