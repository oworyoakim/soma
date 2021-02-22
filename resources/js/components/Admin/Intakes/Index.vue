<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading" />
        <template v-else>
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{title}}</h3>
                    <div class="card-tools">
                        <button type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                data-toggle="tooltip"
                                title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button @click="editIntake()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="New Course">
                            <i class="fas fa-plus"></i>
                            Add Intake
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <IntakesList />
                </div>
            </div>
            <IntakeForm />
        </template>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import IntakesList from "./IntakesList";
import IntakeForm from "./IntakeForm";

export default {
    props: ['title'],
    components: {IntakesList, IntakeForm},
    created() {
        this.getIntakes();
        EventBus.$on(["INTAKE_SAVED"], this.getIntakes);
    },
    computed: {
        ...mapGetters({
            isLoading: 'LOADING',
            intakes: 'INTAKES',
        }),
    },
    methods: {
        editIntake(intake = null) {
            EventBus.$emit('EDIT_INTAKE', intake);
        },
        getIntakes(){
            return this.$store.dispatch("GET_INTAKES");
        }
    }
}
</script>

<style scoped>

</style>
