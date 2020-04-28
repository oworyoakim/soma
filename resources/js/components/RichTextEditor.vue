<template>
        <textarea :value="content"
                  :rows="rows || 3"
                  :placeholder="placeholder"
                  @change="onEditorChange"
                  ref="richTextArea"
                  id="richTextArea"
        >
        </textarea>
</template>

<script>
    export default {
        props: {
            value: String,
            rows: Number,
            height: Number,
            minHeight: Number,
            maxHeight: Number,
            placeholder: String,
        },
        data() {
            return {
                content: '',
            }
        },
        mounted() {
            this.content = this.value;
            $(this.$refs.richTextArea).summernote({
                height: this.height || 300,                 // set editor height
                minHeight: this.minHeight || null,             // set minimum height of editor
                maxHeight: this.maxHeight || null,             // set maximum height of editor
                focus: true,                 // set focus to editable area after initializing summernote
                callbacks: {
                    onInit: (event) => {
                        event.currentTarget.innerHTML = this.content;
                    },
                    onBlur: (event) => {
                        console.log(event.currentTarget.innerHTML);
                        this.content = event.currentTarget.innerHTML;
                    }
                }
            });
        },
        methods: {
            onEditorChange(event) {
                console.log(event);
                console.log('editor change!', this.content);
                this.$emit('input', this.content);
            },
        },
        //<app-rich-text-editor v-model="content" placeholder="Enter descriptions" />
    }
</script>

<style scoped>
    .rich-text-editor {
        padding-bottom: 20px;
    }
</style>
