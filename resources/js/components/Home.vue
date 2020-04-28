<template>
    <v-layout app>
        <app-widget icon="folder" text="Available Courses" num="10"></app-widget>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                user: 'LOGGED_IN_USER',
            }),
        }
    }
</script>

<style scoped>

</style>
