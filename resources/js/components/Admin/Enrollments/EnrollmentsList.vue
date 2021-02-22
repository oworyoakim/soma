<template>
    <div class="mx-auto">
        <div class="row">
            <template v-for="enrollment in enrollments">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <EnrollmentCard :enrollment="enrollment"/>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import EnrollmentCard from "./EnrollmentCard";
import {mapGetters} from "vuex";
export default {
    components: {EnrollmentCard},
    computed: {
        ...mapGetters({
            enrollmentsInfo: "ENROLLMENTS",
        }),
        enrollments(){
            if(!this.enrollmentsInfo){
                return [];
            }
            return this.enrollmentsInfo.data;
        }
    },
}
</script>

<style scoped>

</style>
