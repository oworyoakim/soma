<template>
    <div class="iframe-container">
        <template v-if="classroomId">
            <iframe :src="baseUrl + '/zoom-classroom?classroomId='+ classroomId" :height="height"
                    width="100%" allowfullscreen></iframe>
        </template>
    </div>
</template>
<script>

export default {
    name: "ZoomFrame",
    props: {
        classroomId: {
            type: Number,
            default: null,
            required: true
        }
    },
    computed: {
        height() {
            return (window.innerHeight * 0.75) + 2;
        },
    },
    created() {

    },
    methods: {},
};
</script>
<style>
</style>
