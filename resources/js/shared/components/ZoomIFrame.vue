<template>
    <div class="iframe-container">
        <iframe :src="baseUrl + '/zoom-classroom?classroomId=1'" :height="height" width="100%" allowfullscreen></iframe>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    name: "ZoomFrame",
    computed: {
        ...mapGetters({
            activeTopic: "ACTIVE_TOPIC",
        }),
        height(){
            return (window.innerHeight * 0.75) + 2;
        },
    },
    created() {

    },
    methods: {

    },
};
</script>
<style>
</style>
