<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Title</th>
            <th class="w-50">Description</th>
            <th class="text-center">Topics</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="module in modules">
            <td>{{module.title}}</td>
            <td v-html="module.description"></td>
            <td class="text-center">{{module.numTopics}}</td>
            <td>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.view'])"
                        class="btn btn-sm btn-info mr-2"
                        @click="viewModule(module)">
                    <i class="fa fa-eye"></i>
                </button>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.update'])"
                        class="btn btn-sm btn-info mr-2"
                        @click="editModule(module)">
                    <i class="fa fa-edit"></i>
                </button>
                <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.delete'])"
                        class="btn btn-sm btn-danger"
                        @click="deleteModule(module)">
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
        computed: {
            ...mapGetters({
                modules: 'MODULES',
            })
        },
        methods: {
            viewModule(module) {
                //this.$store.commit('SET_ACTIVE_MODULE', module);
                this.$store.dispatch("GET_MODULE_DETAILS", {moduleId: module.id});
            },
            editModule(module = null) {
                EventBus.$emit('EDIT_MODULE', module);
            },

            deleteModule(module) {

            },
        }
    }
</script>

<style scoped>

</style>
