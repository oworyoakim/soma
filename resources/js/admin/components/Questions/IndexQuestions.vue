<template>
    <div class="card">
        <template v-if="!!activeQuestion">
            <div class="card-header">
                <button type="button"
                        class="btn btn-secondary btn-sm float-right"
                        @click="backToQuestions()">
                    Cancel
                </button>
            </div>
            <div class="card-body">
                <template v-if="activeQuestion">
                    <div class="row">
                        <div class="col-md-12 h3" v-html="activeQuestion.description"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-check my-1" v-for="answer in activeQuestion.answers">
                                <input type="radio" class="form-check-input" disabled>
                                <div class="form-check-label h5" v-html="answer.description"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
        <template v-else>
            <div class="card-header">
                <button type="button"
                        class="btn btn-primary btn-sm float-right"
                        @click="editQuestion()">
                    Add Question
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6" v-for="question in questions" :key="question.id">
                        <QuestionCard :question="question" :key="question.id"/>
                    </div>
                </div>
            </div>
            <QuestionForm/>
        </template>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import QuestionForm from "./QuestionForm";
    import QuestionCard from "./QuestionCard";

    export default {
        components: {QuestionCard, QuestionForm},
        props: {
            questions: {
                type: Array,
                required: true,
                default: () => []
            },
        },
        computed: {
            ...mapGetters({
                activeQuestion: "ACTIVE_QUESTION",
            })
        },
        methods: {
            editQuestion(question = null) {
                EventBus.$emit("EDIT_QUESTION", question);
            },
            backToQuestions() {
                this.$store.commit("SET_ACTIVE_QUESTION", null);
            },
        }
    }
</script>

<style scoped>

</style>
