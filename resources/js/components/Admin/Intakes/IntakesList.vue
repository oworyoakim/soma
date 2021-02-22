<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Name</th>
            <th>Enrollments</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="intake in intakes">
            <td>{{intake.title}}</td>
            <td>{{intake.numberOfEnrollments}}</td>
            <td>

            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            intakes: 'INTAKES',
        }),
    }
}
</script>

<style scoped>

</style>
