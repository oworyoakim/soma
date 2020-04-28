<template>
    <v-card flat>
        <v-card-title class="headline">
            Questions
            <v-spacer/>
            <v-btn color="primary" dark class="mb-2" @click="editQuestion()">Add Question</v-btn>
        </v-card-title>
        <v-expansion-panels>
            <v-expansion-panel v-for="question in questions" :key="question.id">
                <v-expansion-panel-header>Question {{question.id}}</v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-card flat>
                        <v-card-title v-html="question.title"></v-card-title>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn color="primary" outlined small @click="openQuestionModal(question)">View</v-btn>
                            <v-btn color="warning" outlined small @click="deleteQuestion(question)">Delete</v-btn>
                            <v-btn color="info" small @click="editQuestion(question)">Edit</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
<!--        <v-card-text class="row wrap">-->
<!--            <v-flex sm12 md4 lg3 v-for="question in questions" :key="question.id">-->
<!--                <v-card class="ma-2" max-height="400px">-->
<!--                    <v-card-title class="headline" v-html="question.title"></v-card-title>-->

<!--                    <v-card-subtitle v-html="question.description"></v-card-subtitle>-->

<!--                    <v-card-actions>-->
<!--                        <v-spacer/>-->
<!--                        <v-btn color="primary" outlined small @click="openQuestionModal(question)">View</v-btn>-->
<!--                        <v-btn color="warning" outlined small @click="deleteQuestion(question)">Delete</v-btn>-->
<!--                        <v-btn color="info" small @click="editQuestion(question)">Edit</v-btn>-->
<!--                    </v-card-actions>-->
<!--                </v-card>-->
<!--            </v-flex>-->
<!--        </v-card-text>-->
        <template v-if="!!activeQuestion">
            <app-main-modal :is-open.sync="isOpen" @close-modal="closeQuestionModal">
                <v-card flat class="justify-center">
                    <v-list three-line subheader>
                        <v-subheader>
                            Question
                        </v-subheader>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title v-html="activeQuestion.title"></v-list-item-title>
<!--                                <v-list-item-subtitle v-html="activeQuestion.description"></v-list-item-subtitle>-->
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list three-line subheader>
                        <v-subheader>
                            Answers
                            <v-spacer></v-spacer>
                            <v-btn color="primary" dark class="mt-4" @click="editAnswer()">Add Answer</v-btn>
                        </v-subheader>
                        <v-list-item-group class="mt-2">
                            <v-list-item v-for="answer in activeQuestion.answers" :key="answer.id">
                                <v-list-item-icon>
                                    <v-checkbox v-model="answer.correct" color="primary" disabled></v-checkbox>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-subtitle>{{answer.title}}</v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-icon @click="editAnswer(answer)" title="Edit">
                                    <v-icon color="primary">edit</v-icon>
                                </v-list-item-icon>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                    <app-answer-form v-if="!!activeQuestion" :question-id="activeQuestion.id"/>
                </v-card>
            </app-main-modal>
        </template>
        <app-question-form :module-id="moduleId" :topic-id="topicId"/>
    </v-card>
</template>

<script>
    import Question from "../../../models/Question";
    import {EventBus} from "../../../app";

    export default {
        props: {
            questions: {
                type: Array,
                required: true,
                default: () => []
            },
            moduleId: Number,
            //topicId: Number,
        },
        data() {
            return {
                isOpen: false,
                isQuestionFormOpen: false,
                activeQuestion: null,
                question: new Question(),
            }
        },
        methods: {
            openQuestionModal(question) {
                this.activeQuestion = question;
                this.isOpen = true;
            },
            closeQuestionModal() {
                this.isOpen = false;
                this.activeQuestion = null;
            },

            editQuestion(question = null) {
                EventBus.$emit("ADD_QUESTION", question);
            },
            deleteQuestion(question) {
            },

            editAnswer(answer = null) {
                EventBus.$emit("EDIT_ANSWER", answer);
            },
        }
    }
</script>

<style scoped>

</style>
