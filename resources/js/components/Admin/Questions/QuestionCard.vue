<template>
    <div class="card card-outline card-info">
        <div class="card-header">
            <h4 class="card-title text-bold">Question {{question.id}}</h4>
            <div class="card-tools">
                <label v-if="question.type === 'revision'">Revision</label>
                <label v-else>Examinable</label>
            </div>
        </div>
        <div class="card-body">
            <div class="card-text" v-html="stringLimit(question.description,200)"></div>
        </div>
        <div class="card-footer text-right">
            <button
                type="button"
                class="btn btn-outline-warning btn-sm mr-2"
                @click="deleteQuestion(question)">
                Delete
            </button>
            <button
                type="button"
                class="btn btn-outline-info btn-sm mr-2"
                @click="editQuestion(question)">
                Edit
            </button>
            <button
                type="button"
                class="btn btn-outline-info btn-sm"
                @click="viewQuestion(question)">
                View
            </button>
            <button
                type="button"
                class="btn btn-outline-info btn-sm"
                @click="previewQuestion(question)">
                Preview
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            question: {
                type: Object,
                required: true,
                default: () => null
            },
        },
        methods: {
            editQuestion(question = null) {
                EventBus.$emit("EDIT_QUESTION", question);
            },

            deleteQuestion(question) {
            },

            viewQuestion(question) {
                this.$store.commit("SET_ACTIVE_QUESTION", question);
            },

            previewQuestion(question){

            },

            editAnswer(answer = null) {
                EventBus.$emit("EDIT_ANSWER", answer);
            },
        }
    }
</script>

<style scoped>

</style>
