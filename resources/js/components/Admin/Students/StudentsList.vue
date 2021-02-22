<template>
    <div class="row">
        <template v-for="student in students">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <StudentCard :student="student" :key="'student-' + student.id"/>
            </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import StudentCard from "./StudentCard";

export default {
    components: {StudentCard},
    computed: {
        ...mapGetters({
            studentsInfo: 'STUDENTS',
        }),
        students(){
            if(!this.studentsInfo){
                return [];
            }
            return this.studentsInfo.data;
        },
    },
}
</script>

<style scoped>

</style>
