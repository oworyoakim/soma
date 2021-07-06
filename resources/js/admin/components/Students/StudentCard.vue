<template>
    <div class="info-box" v-if="!!student">
        <span class="info-box-icon bg-light">
            <img v-if="student.avatar" :src="student.avatar" alt="Image"/>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">{{ student.firstName }} {{ student.lastName }}</span>
            <span class="info-box-number">{{ student.numberOfEnrollments }} programs</span>
            <span class="info-box-number">{{ student.numberOfExams }} exams sat</span>
            <div class="progress">
                <div class="progress-bar bg-info" style="width: 100%"></div>
            </div>
            <span class="progress-description">
                <button v-if="$store.getters.HAS_ANY_ACCESS(['students.delete'])"
                        @click="deleteStudent()"
                        class="btn btn-outline-warning btn-link btn-sm">
                    Delete
                </button>
                &nbsp;&nbsp;
                <button v-if="$store.getters.HAS_ANY_ACCESS(['students.update'])"
                        @click="editStudent()"
                        class="btn btn-outline-info btn-link btn-sm">
                    Edit
                </button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        student: {
            type: Object,
            required: true,
            default: () => null,
        }
    },
    methods: {
        editStudent() {
            EventBus.$emit('EDIT_STUDENT', this.student);
        },
        deleteStudent() {
            EventBus.$emit('DELETE_STUDENT', this.student);
        }
    }
}
</script>

<style scoped>

</style>
