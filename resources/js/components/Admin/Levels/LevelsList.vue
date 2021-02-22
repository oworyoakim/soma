<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Name</th>
            <th>Courses</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="level in levels">
            <td>{{level.title}}</td>
            <td>{{level.numCourses}}</td>
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
                levels: 'LEVELS',
            })
        }
    }
</script>

<style scoped>

</style>
