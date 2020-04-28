<template>
    <quill-editor class="rich-text-editor bubble"
                  ref="richTextEditor"
                  :content="content"
                  :options="editorOptions"
                  @change="onEditorChange($event)">
    </quill-editor>
</template>

<script>
    export default {
        props: {
            value: String,
            placeholder: String,
        },
        data() {
            return {
                content: '',
                editorOptions: {
                    theme: 'snow',
                    placeholder: this.placeholder || '',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{'header': 1}, {'header': 2}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            [{'script': 'sub'}, {'script': 'super'}],
                            [{'indent': '-1'}, {'indent': '+1'}],
                            [{'direction': 'rtl'}],
                            [{'size': ['small', false, 'large', 'huge']}],
                            [{'header': [1, 2, 3, 4, 5, 6, false]}],
                            [{'font': []}],
                            [{'color': []}, {'background': []}],
                            [{'align': []}],
                            ['clean'],
                            ['link', 'image', 'video']
                        ]
                    }
                }
            }
        },
        mounted() {
            setTimeout(() => {
                this.content = this.value;
            }, 500);
        },
        methods: {
            onEditorChange({editor, html, text}) {
                console.log('editor change!', editor, html, text);
                this.content = html;
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
