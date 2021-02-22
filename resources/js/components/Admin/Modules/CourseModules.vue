<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-tools">
                <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.create'])"
                        @click="editModule()"
                        type="button"
                        class="btn btn-sm btn-dark"
                        data-card-widget="add"
                        title="New Course">
                    <i class="fas fa-plus"></i>
                    Add Module
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <ModulesList/>
        </div>
    </div>
</template>

<script>
    import ModulesList from "./ModulesList";

    export default {
        computed: {},
        components: {ModulesList},
        methods: {
            editModule(module = null) {
                EventBus.$emit("EDIT_MODULE", module);
            },
        },
    }
</script>

<style scoped>

</style>
