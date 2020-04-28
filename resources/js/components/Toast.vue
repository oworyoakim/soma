<template>
    <v-snackbar
        v-model="snackbar.showing"
        :color="snackbar.context"
        top
        multi-line
        right
        :timeout="snackbar.timeout"
    >
        {{ snackbar.text }}
    </v-snackbar>
</template>

<script>

    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                snackbar: "SNACKBAR"
            }),
        },
    }
</script>

<style scoped>

</style>
