<template>
    <v-layout v-if="!!activeQuestion">
        <v-container>
            <v-row row wrap>
                <v-flex xs12 sm8 md9 lg9 xl9>
                    <v-card class="mr-2">
                                               <v-card-title class="mb-2"><h1>{{ examInfo.courseTitle }}</h1></v-card-title>
                        <v-card-title>
                            <h3>Question {{ activeQuestionIndex + 1 }}</h3>
                        </v-card-title>
                        <v-card-text>
                            <p class="display-1">{{ activeQuestion.title }}</p>
                            <v-list>
                                <v-list-item v-for="answer in activeQuestion.answers" :key="answer.id">
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            <v-checkbox :key="answer.id" v-model="answer.selected"
                                                        :label="answer.title"></v-checkbox>
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                v-if="activeQuestionIndex > 0"
                                class="ma-2"
                                width="150px"
                                tile
                                color="info"
                                @click="previousQuestion()"
                                dark>
                                <v-icon left dark>mdi-skip-previous</v-icon>
                                Previous
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn
                                v-if="activeQuestionIndex < questions.length - 1"
                                class="ma-2"
                                width="150px"
                                tile
                                color="primary"
                                @click="nextQuestion()"
                                dark>Next
                                <v-icon right dark>mdi-skip-next</v-icon>
                            </v-btn>
                            <v-btn
                                v-else
                                class="ma-2"
                                width="150px"
                                tile
                                color="success"
                                @click="confirmFinish = !confirmFinish"
                                dark>Submit & Finish
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
                <v-flex xs12 sm4 md3 lg3 xl3>
                    <v-card class="ml-2">
                        <v-card-title>
                            <h3 v-text="`Time: ${timer}`"></h3>
                        </v-card-title>

                        <v-card-text>
                            <v-list-item-subtitle class="mb-2">
                                <div class="text-center">
                                    <span class="title">Question</span>
                                    <br/>
                                    <span>{{ activeQuestionIndex + 1 }}/{{questions.length}}</span>
                                </div>
                            </v-list-item-subtitle>
                            <template v-for="(question,index) in questions">
                                <v-btn :key="index"
                                    v-if="activeQuestion.id === question.id"
                                    @click="setActiveQuestion(index)"
                                    class="ma-1"
                                    color="primary">
                                    {{ index + 1 }}
                                </v-btn>
                                <v-btn :key="index"
                                    v-else-if="answeredQuestions.includes(question.id)"
                                    color="green"
                                    class="ma-1"
                                    @click="setActiveQuestion(index)">
                                    {{ index + 1 }}
                                </v-btn>
                                <v-btn :key="index" v-else @click="setActiveQuestion(index)" class="ma-1">
                                    {{ index + 1 }}
                                </v-btn>
                            </template>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-row>
            <!-- start of exam confirmation -->
            <div class="text-center">
            <v-dialog persistent v-model="confirmFinish" width="500">
                <v-card>
                <v-card-title class="title grey lighten-2">Confirm</v-card-title>
                <v-card-text class="subtitle">
                    <br />
                    Are you sure you want to Complete the
                    <b>Exam</b> now?
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" outlined @click="confirmFinish = !confirmFinish">Cancel</v-btn>
                    <v-btn color="primary" @click="approve(); stopWatch()">Continue</v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>
            </div>
            <!-- Results view -->
            <div class="text-center">
                <v-dialog persistent v-model="completeExam" width="1250">
                    <v-card>
                    <v-card-title class="title grey lighten-2">Your Results
                        <v-spacer></v-spacer>
                        Time spent<v-btn color="purple" text  class="title">{{timeTaken}}</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-sheet class="mx-auto" elevation="0">
                            <v-slide-group v-model="model" class="pa-4" :center-active="centerActive">
                                <v-card color= "grey lighten-4" class="ma-4" height="200"  max-width="250">
                                    <v-card-subtitle class="subtitle grey lighten-2">Total No. of Questions</v-card-subtitle>
                                    <v-card-actions>
                                    <v-btn text>Value :</v-btn>
                                    <v-btn color="purple" class="title" text >54</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                    <div>
                                        <v-divider></v-divider>
                                        <v-card-text class="text--secondary caption">
                                        These are all the questions that you were expected to complete.
                                        </v-card-text>
                                    </div>
                                </v-card>
                                <v-card color= "grey lighten-4" class="ma-4" height="200"  max-width="250">
                                    <v-card-subtitle class="subtitle grey lighten-2">Questions Answered</v-card-subtitle>
                                    <v-card-actions>
                                    <v-btn text>Value :</v-btn>
                                    <v-btn color="purple" text class="title">24</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                    <div>
                                        <v-divider></v-divider>
                                        <v-card-text class="text--secondary caption">
                                        These are all the questions that were answered.
                                        </v-card-text>
                                    </div>
                                </v-card>
                                <v-card color= "grey lighten-4" class="ma-4" height="200"  max-width="250">
                                    <v-card-subtitle class="subtitle grey lighten-2">Questions Unanswered</v-card-subtitle>
                                    <v-card-actions>
                                    <v-btn text>Value :</v-btn>
                                    <v-btn color="purple" text class="title">30</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                    <div>
                                        <v-divider></v-divider>
                                        <v-card-text class="text--secondary caption">
                                        These are all the questions that were Unanswered.
                                        </v-card-text>
                                    </div>
                                </v-card>
                                <v-card color= "grey lighten-4" class="ma-4" height="200"  max-width="250">
                                    <v-card-subtitle class="subtitle grey lighten-2">Overall Percentile</v-card-subtitle>
                                    <v-card-actions>
                                    <v-btn text>Value :</v-btn>
                                    <v-btn color="purple" text  class="title">63%</v-btn>
                                    <v-spacer></v-spacer>
                                    </v-card-actions>
                                    <div>
                                        <v-divider></v-divider>
                                        <v-card-text class="text--secondary caption">
                                        This is the score that you obtained in this exam.
                                        </v-card-text>
                                    </div>
                                </v-card>
                            </v-slide-group>
                        </v-sheet>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="completeCourseExam()">Close</v-btn>
                    </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-container>
    </v-layout>
</template>

<script>
    import moment from "moment";
    import {mapGetters} from "vuex";
    import { baseUrl } from "../../app";
    let timer;
    export default {
         beforeMount() {
            window.addEventListener("beforeunload", this.preventNav);
            this.$once("hook:beforeDestroy", () => {
                window.removeEventListener("beforeunload", this.preventNav);
            })
        },
        beforeRouteLeave(to, from, next) {
            if (this.examStatus === 'ongoing') {
                if (!window.confirm("Submit and Finish?")) {
                    return;
                }
            }
            next();
        },
        preventNav(event) {
            if (this.examStatus === 'ongoing') {
                return;
            }
            event.preventDefault();
            event.returnValue = "";
        },
        data() {
            return {
                activeQuestionIndex: 0,
                answeredQuestions: [],
                activeQuestion: null,
                timer: "",
                completeExam:false,
                model: null,
                multiple: false,
                mandatory: false,
                showArrows: true,
                centerActive: false,
                isEditing: false,
                show: false,
                confirmFinish: false,
                timeTaken: ""
            };
        },

        computed: {
            ...mapGetters({
                examInfo: "EXAM_INFO",
                examStatus: "EXAM_STATUS",
                course: "GET_ACTIVE_COURSE"
            }),
            questions() {
                return this.examInfo.questions;
            },
        },

        mounted() {
            this.setActiveQuestion(this.activeQuestionIndex);
            this.timeCount();
        },

        created() {
        },

        methods: {
            completeCourseExam() {
                !this.completeExam;
                let url = baseUrl + "/my-courses/";
                window.location.href = url
                const closeWin = window.close(url);
                closeWin.focus();
                },
            async approve() {
                !this.confirmFinish;
                this.completeExam = true;
            },
            
            timeCount() {
                var countDownDate = moment().add(this.examInfo.examDuration, "minutes");
                const dateC = moment(this.examInfo.examDuration);
                timer = setInterval((i) => {
                    let diff = countDownDate.diff(moment());
                
                    if (diff <= 0) {
                        clearInterval(timer);
                    } else {
                        this.timer = moment.utc(diff).format("HH:mm:ss");
                        this.timeTaken = moment.utc(moment.duration(diff,"s").asMinutes()).format("HH:mm:ss");
                    }
                }, 1000);

            },
            
            stopWatch() {
                clearInterval(timer);
            },


            savedAnswer(questionId) {
                let sa = "{" + questionId + ": " + this.selectedAnswer + "}";
                this.studentAnswer.push(sa);
                this.answeredQuestion.push(questionId);
            },

            selectedAnswers(child) {
                this.currentAnswer = child;
                if (this.selectedAnswer.includes(child.answer)) {
                    let ind = this.selectedAnswer.indexOf(child.answer);
                    this.selectedAnswer.splice(ind, 1);
                } else {
                    this.selectedAnswer.push(child.answer);
                }
            },

            setActiveQuestion(index) {
                let question = this.questions[index];
                if (!question) {
                    return;
                }
                this.activeQuestion = question;
                this.activeQuestionIndex = index;
                this.setAnsweredQuestions();
            },

            removeAnsweredQuestion(question) {
                let index = this.answeredQuestions.indexOf(question.id);
                this.answeredQuestions.splice(index, 1);
            },

            setAnsweredQuestions() {
                this.questions.forEach((question) => {
                    let exists = question.answers.some((answer) => {
                        return !!answer.selected;
                    });
                    if (exists) {
                        this.question.answered = true;
                        if (!this.answeredQuestions.includes(question.id)) {
                            this.answeredQuestions.push(question.id);
                        }
                    } else {
                        this.removeAnsweredQuestion(question);
                    }
                });
            },
            nextQuestion() {
                let index = this.activeQuestionIndex + 1;
                if (index === this.questions.length) {
                    return;
                }
                this.setActiveQuestion(index);
            },
            previousQuestion() {
                let index = this.activeQuestionIndex - 1;
                if (index < 0) {
                    return;
                }
                this.setActiveQuestion(index);
            },
        }
    };
</script>
