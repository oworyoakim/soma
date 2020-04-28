<template>
    <router-view></router-view>
</template>

<script>
    export default {
        created() {
            this.$store.dispatch("GET_EXAMS", {});
        },
    }
</script>

<style scoped>

</style>
