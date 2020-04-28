<template>
    <video controls
           :height="height"
           :width="width"
           controlsList="nodownload"
           disablePictureInPicture
    >
        <source :src="src">
    </video>
</template>

<script>
    export default {
        props: {
            src: String,
            width: String,
            height: String,
        }
    }
</script>

<style scoped>

</style>
