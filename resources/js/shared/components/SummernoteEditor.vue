<template>
    <textarea class="form-control"
              ref="summernoteEditor"
              :placeholder="placeholder"
              :value="value"
              style="width: 100%; font-size: 14px;">
    </textarea>
</template>

<script>
const $ = require('admin-lte/plugins/jquery/jquery.slim.min');
import "admin-lte/plugins/summernote/summernote-bs4.min.js";
export default {
    name: "SummernoteEditor",
    props: {
        placeholder: String,
        value: {
            type: String,
            default: "",
        },
        height: {
            type: Number,
            required: false,
            default: 160
        },
    },
    data() {
        return {
            summernoteEditor: null,
            isChanging: false,
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.summernoteEditor = $(this.$refs.summernoteEditor);
            console.log(this.summernoteEditor);
            //Init the Awesome Summernote Text Editor
            this.summernoteEditor.summernote({
                height: this.height,
                callbacks: {
                    onChange: (contents) => {
                        console.log(contents);
                        if (!this.isChanging) {
                            this.isChanging = true;
                            this.$emit('input', contents);
                            this.$nextTick(() => {
                                this.isChanging = false;
                            });
                        }
                    },
                    onInit: () => {
                        let content = this.value || "";
                        this.summernoteEditor.summernote("code", content);
                    },
                }
            });
        });
    },
    watch: {
        "value"(newVal, oldVal){
            if (!this.isChanging) {
                this.isChanging = true;
                let content = newVal || "";
                this.summernoteEditor.summernote("code", content);
                this.isChanging = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>

</style>
