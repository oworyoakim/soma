<template>
    <div class="container-fluid  pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else>
            <LogbooksList title="Flight Activity"/>
        </template>
        <LogbookForm />
    </div>
</template>

<script>
    import LogbookForm from "./LogbookForm";
    import LogbooksList from "./LogbooksList";
    import {mapGetters} from "vuex";

    export default {
        components: {LogbooksList, LogbookForm,},
        mounted() {
            this.getLogbooks().then(() => {
                this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS");
            });
        },
        computed: {
            ...mapGetters({
                isLoading: "LOADING",
            }),
        },
        methods: {
            getLogbooks() {
                return this.$store.dispatch("GET_LOGBOOKS");
            }
        },
    }
</script>

<style scoped>

</style>
