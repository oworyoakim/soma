<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ title }}</h3>
            <div class="card-tools">
                <button @click="editExam()" class="btn btn-dark btn-sm">
                    <i class="fas fa-plus"></i> New Exam
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-condensed table-sm">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Program</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Duration</th>
                    <th>PassMark</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="exam in exams">
                    <td>{{ exam.code }}</td>
                    <td>{{ exam.title }}</td>
                    <td>
                        <template v-if="exam.program">
                            {{ exam.program.title }}
                        </template>
                    </td>
                    <td>
                        <template v-if="exam.course">
                            {{ exam.course.title }}
                        </template>
                    </td>
                    <td>
                        <template v-if="exam.level">
                            {{ exam.level.title }}
                        </template>
                    </td>
                    <td>{{ exam.duration }}</td>
                    <td>{{ exam.passMark }}</td>
                    <td>
                        <button class="btn btn-sm btn-info mr-2" @click="viewExam(exam)">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-info mr-2" @click="previewExam(exam)">
                            <i class="fa fa-eye-dropper"></i>
                        </button>
                        <button class="btn btn-sm btn-info mr-2" @click="editExam(exam)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" @click="deleteExam(exam)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props: ['title'],
    data(){
        return {

        }
    },
    computed: {
        ...mapGetters({
            exams: "EXAMS",
        }),
    },
    methods: {
        viewExam(exam = null) {
            this.$store.commit("SET_ACTIVE_EXAM", exam);
        },
        editExam(exam) {
            EventBus.$emit("EDIT_EXAM", exam);
        },
        deleteExam(exam) {

        },
        previewExam(exam){
            EventBus.$emit("PREVIEW_EXAM", {examId: exam.id});
        },
    },
}
</script>

<style scoped>

</style>
