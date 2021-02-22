<template>
    <h2>Welcome to SOMA!!!</h2>
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
