<template>
    <table class="table table-striped table-valign-middle">
        <thead>
        <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>AgeLimit</th>
            <th>PassMark</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <template v-if="programs.length > 0">
            <template v-for="program in programs">
                <tr>
                    <td>{{ program.title }}</td>
                    <td>{{ program.duration }} months</td>
                    <td>{{ program.ageLimit }}</td>
                    <td>{{ program.passMark }}</td>
                    <td>
                        <button type="button" title="View Program" class="btn btn-xs btn-info mr-2" @click="viewProgram(program)">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" title="Edit Program" class="btn btn-xs btn-info mr-2" @click="editProgram(program)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" title="Delete Program" class="btn btn-xs btn-danger" @click="deleteProgram(program)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </template>
        </template>
        <template v-else>
            <tr>
                <td colspan="4">No data!</td>
            </tr>
        </template>
        </tbody>
    </table>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            programs: "PROGRAMS",
        }),
    },
    methods: {
        viewProgram(program = null) {
            this.$store.commit("SET_ACTIVE_PROGRAM", program);
        },
        editProgram(program = null) {
            EventBus.$emit("EDIT_PROGRAM", program);
        },

        deleteProgram(program) {

        },
    },
}
</script>

<style scoped>

</style>
