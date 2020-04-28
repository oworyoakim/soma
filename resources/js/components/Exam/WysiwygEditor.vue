<template>
    <rich-text-editor :value="content" @update="onUpdate"/>
</template>

<script>
    export default {
        methods:{
            onUpdate (text) {
                this.content = text;
                this.$emit('input',this.content);
            }
        }
    }
</script>

<style scoped>

</style>
