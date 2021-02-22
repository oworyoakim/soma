<template>
    <div class="container-fluid  pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else-if="activeProgram">
            <ProgramDetails/>
        </template>
        <template v-else>
            <div class="card card-info card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">{{ title }}</h3>
                    <div class="card-tools">
                        <button @click="editProgram()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="New Program">
                            <i class="fas fa-plus"></i>
                            Add Program
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <ProgramsList/>
                </div>
            </div>
        </template>
        <ProgramForm/>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ProgramForm from "./ProgramForm";
import ProgramsList from "./ProgramsList";
import ProgramDetails from "./ProgramDetails";

export default {
    props: ["title"],
    components: {ProgramsList, ProgramForm, ProgramDetails},
    created() {
        this.getPrograms();
        EventBus.$on(['PROGRAM_SAVED'], this.getPrograms);
    },
    computed: {
        ...mapGetters({
            isLoading: "LOADING",
            activeProgram: "ACTIVE_PROGRAM",
        }),
    },
    methods: {
        editProgram(program = null) {
            EventBus.$emit("EDIT_PROGRAM", program);
        },
        getPrograms() {
            return this.$store.dispatch('GET_PROGRAMS');
        }
    }
}
</script>

<style scoped>

</style>
