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
                        <button @click="editLevel()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="New Course">
                            <i class="fas fa-plus"></i>
                            Add Level
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <LevelsList />
                </div>
            </div>
            <LevelForm />
        </template>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import LevelsList from "./LevelsList";
    import LevelForm from "./LevelForm";

    export default {
        props: ['title'],
        components: {LevelsList, LevelForm},
        computed: {
            ...mapGetters({
                isLoading: 'LOADING',
            }),
        },
        methods: {
            editLevel(level = null) {
                EventBus.$emit('EDIT_LEVEL', level);
            }
        }
    }
</script>

<style scoped>

</style>
