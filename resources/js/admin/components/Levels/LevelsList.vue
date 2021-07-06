<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Name</th>
            <th>Learning Path</th>
            <th class="text-center">Courses</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="level in levels">
            <td>{{level.title}}</td>
            <td>
                <template v-if="level.learningPath">
                    {{level.learningPath.title}}
                </template>
            </td>
            <td class="text-center">{{level.numberOfCourses}}</td>
            <td>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['levels.update'])"
                        class="btn btn-sm btn-info mr-2"
                        @click="editLevel(level)">
                    <i class="fa fa-edit"></i>
                </button>
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
        },
        methods: {
            editLevel(level = null) {
                EventBus.$emit('EDIT_LEVEL', level);
            },
        },
    }
</script>

<style scoped>

</style>
