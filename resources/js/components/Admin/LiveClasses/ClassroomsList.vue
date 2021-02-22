<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Time</th>
            <th>Duration</th>
            <th>Course</th>
            <th>Module</th>
            <th>Topic</th>
            <th>Password</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="classroom in classrooms">
            <td>{{classroom.meetingId}}</td>
            <td>{{classroom.title}}</td>
            <td>{{classroom.startTime}}</td>
            <td>{{classroom.duration}} mins</td>
            <td>
                <template v-if="classroom.course">
                    {{classroom.course.title}}
                </template>
            </td>
            <td>
                <template v-if="classroom.module">
                    {{classroom.module.title}}
                </template>
            </td>
            <td>
                <template v-if="classroom.topic">
                    {{classroom.topic.title}}
                </template>
            </td>
            <td>{{classroom.meetingPassword}}</td>
            <td>{{classroom.status}}</td>
            <td>
                <button class="btn btn-sm btn-info mr-2" @click="viewClassroom(classroom)">
                    <i class="fa fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-info mr-2" @click="previewClassroom(classroom)" title="Preview">
                    <i class="fa fa-prescription"></i>
                </button>
                <button class="btn btn-sm btn-info mr-2" @click="editClassroom(classroom)">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" @click="deleteClassroom(classroom)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed:{
        ...mapGetters({
            classrooms: "CLASSROOMS"
        }),
    },
    methods: {
        viewClassroom(classroom){

        },
        previewClassroom(classroom){
            EventBus.$emit("PREVIEW_CLASSROOM", classroom);
        },
        editClassroom(classroom = null){
            EventBus.$emit("EDIT_CLASSROOM", classroom);
        },
        deleteClassroom(classroom){

        },
    },
}
</script>

<style scoped>

</style>
