<template>
    <div class="card card-outline ma-1">
        <div class="card-header bg-secondary" v-if="enrollment.student">
            <span>Student: </span>
            <span class="float-right">{{ enrollment.student.fullName }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <span>Program: </span>
                </div>
                <div class="col-9 text-right">
                    <span v-if="enrollment.program">{{ enrollment.program.title }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <span>Intake: </span>
                </div>
                <div class="col-9 text-right">
                    <span v-if="enrollment.intake">{{ enrollment.intake.title }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <span>Enrolled On: </span>
                </div>
                <div class="col-9 text-right">
                    <span>{{ $moment(enrollment.enrollDate).format('DD MMM, YYYY') }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    <button type="button" @click="deleteEnrollment()" class="btn btn-warning btn-sm">Delete</button>
                </div>
                <div class="col-6">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        enrollment: {type: Object, required: true}
    },
    methods: {
        editEnrollment() {
            EventBus.$emit("EDIT_ENROLLMENT", this.enrollment);
        },
        deleteEnrollment() {

        },
    }
}
</script>

<style scoped>

</style>
