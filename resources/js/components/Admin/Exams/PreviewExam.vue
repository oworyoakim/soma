<template>
    <FullscreenModal v-if="isPreviewing" @closed="closeExamPreview()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <Spinner v-if="isLoading"/>
            <template v-else-if="examInfo">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <template v-if="viewMode === 'instructions'">
                            <div class="card w-75 mx-auto">
                                <div class="card-header">
                                    <h3 class="card-title">Instructions</h3>
                                </div>
                                <div class="card-body" v-html="examInfo.instructions"></div>
                                <div class="card-footer text-center">
                                    <button type="button"
                                            @click="startExam()"
                                            class="btn btn-info btn-sm">Start Exam
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template v-if="viewMode === 'exam-session'">
                            <div class="card w-75 mx-auto" ref="examSession" @blur.prevent="handleOnBeforeUnload">
                                <div class="card-header">
                                    <h5 class="card-title">Time Spent: {{ timeTaken }}</h5>
                                    <div class="card-tools">Time Left: {{ timeLeft }}</div>
                                </div>
                                <div class="card-body">
                                    <template v-if="activeQuestion">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="h3" v-html="activeQuestion.description"></div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-check my-1"
                                                             v-for="answer in activeQuestion.answers">
                                                            <input type="checkbox"
                                                                   v-model="answer.selected"
                                                                   @change="setAnsweredQuestion(activeQuestion.id)"
                                                                   class="form-check-input">
                                                            <div class="form-check-label h5"
                                                                 v-html="answer.description"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <template v-for="(question,index) in questions">
                                                        <div class="col-6 my-2">
                                                            <template v-if="activeQuestion.id === question.id">
                                                                <button type="button"
                                                                        :key="index"
                                                                        class="btn btn-info btn-sm btn-block active">
                                                                    {{ index + 1 }}
                                                                </button>
                                                            </template>
                                                            <template v-else>
                                                                <button type="button"
                                                                        :key="index"
                                                                        @click="setActiveQuestion(index)"
                                                                        class="btn btn-sm btn-block"
                                                                        :class="isAnswered(question.id) ? 'btn-success': 'btn-default'">
                                                                    {{ index + 1 }}
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="h3">No questions found!</div>
                                    </template>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <template v-if="activeQuestion">
                                            <div class="col-md-3 col-sm-6 text-center">
                                                <button type="button"
                                                        @click="backToInstructions()"
                                                        class="btn btn-warning btn-sm">Back to Instructions
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-sm-6 text-center">
                                                <button type="button"
                                                        v-if="activeQuestionIndex > 0"
                                                        @click="previousQuestion()"
                                                        class="btn btn-dark btn-sm">Previous Question
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-sm-6 text-center">
                                                <button type="button"
                                                        v-if="activeQuestionIndex < (questions.length - 1)"
                                                        @click="nextQuestion()"
                                                        class="btn btn-info btn-sm">Next Question
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-sm-6 text-center">
                                                <button type="button"
                                                        @click="completeExam()"
                                                        class="btn btn-danger btn-sm">Finish & Submit
                                                </button>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="col-md-12 text-center">
                                                <button type="button"
                                                        @click="backToInstructions()"
                                                        class="btn btn-warning btn-sm">Back to Instructions
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            <template v-else>
                <h2>Exam not found!</h2>
            </template>
        </template>
        <template slot="footer">

        </template>
    </FullscreenModal>
</template>

<script>
import FullscreenModal from "../../Shared/FullscreenModal";
import Spinner from "../../Shared/Spinner";

export default {
    components: {FullscreenModal, Spinner},
    created() {
        EventBus.$on("PREVIEW_EXAM", this.previewExam);
        this.stopTimer();
    },
    data() {
        return {
            examConfig: null,
            isLoading: false,
            isPreviewing: false,
            examInfo: null,
            questions: [],
            answeredQuestions: [],
            activeQuestionIndex: 0,
            timer: null,
            startTime: null,
            timeTaken: null,
            timeLeft: null,
            viewMode: 'instructions',
        }
    },
    computed: {
        title() {
            let title = "Examination Preview Page";
            if (this.examInfo) {
                title += `(${this.examInfo.programTitle}/${this.examInfo.courseTitle}/${this.examInfo.intakeTitle})`;
            }
            return title;
        },
        activeQuestion() {
            if (this.questions.length === 0) {
                return null;
            }
            return this.questions[this.activeQuestionIndex];
        },
        isAnswered() {
            return (questionId) => {
                return this.answeredQuestions.includes(questionId);
            }
        },
    },
    methods: {
        closeExamPreview() {
            this.stopTimer();
            this.resetExam();
            this.isPreviewing = false;
        },
        backToInstructions() {
            this.stopTimer();
            this.viewMode = 'instructions';
        },
        async previewExam(examConfig) {
            try {
                console.log(examConfig);
                if (examConfig && (examConfig.slug || examConfig.examId)) {
                    this.examConfig = examConfig;
                    this.isPreviewing = true;
                    await this.getExamInfo();
                }
            } catch (error) {
                console.log(error);
            }
        },
        async getExamInfo() {
            try {
                if (this.examConfig && (this.examConfig.slug || this.examConfig.examId)) {
                    this.isLoading = true;
                    this.examInfo = await this.$store.dispatch("GET_EXAM_INFO", this.examConfig);
                    this.questions = await this.$store.dispatch("GET_EXAM_QUESTIONS", {examId: this.examInfo.id});
                    this.isLoading = false;
                }
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },
        warmBeforeLeaving(event) {
            event.preventDefault();
            if (!document.hasFocus) {
                swal({
                    title: 'Are you sure?',
                    text: "Your exam will be automatically ended and current responses submitted when you leave this window!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, End Exam!'
                }).then(async (isConfirmed) => {
                    if (isConfirmed) {
                        await this.completeExam();
                    }
                });
            }
        },
        startTimer() {
            window.onbeforeunload = this.handleOnBeforeUnload;
            window.onblur = this.completeExam;
            window.onunload = this.completeExam;
            document.addEventListener('visibilitychange', (event) => {
                console.log(document.hidden);
                if(document.hidden){
                    this.completeExam();
                }
            });
            // this.$refs.examSession.addEventListener('blur',(event) => {
            //     event.preventDefault();
            //     return confirm("Are you sure?");
            // });
            //document.addEventListener("blur", this.handleVisibilityChange)
            this.startTime = this.$moment();
            let endTime = this.$moment().add(this.examInfo.duration, "minutes");
            this.timer = setInterval(() => {
                let diff = endTime.diff(this.$moment());
                if (diff <= 0) {
                    this.completeExam();
                } else {
                    this.timeLeft = this.$moment.utc(diff).format("HH:mm:ss");
                    this.timeTaken = this.$moment.utc(this.$moment().add(1, 'seconds').diff(this.startTime) + 1).format("HH:mm:ss");
                }
            }, 1000);
        },
        handleOnBeforeUnload(event) {
            event.cancelBubble = true;
            event.returnValue = 'Are you sure you want to leave?'; //This is displayed on the dialog
            // let confirmed = confirm('Are you sure you want to leave?');
            // if(!confirmed){
            //
            // }
            if (event.stopPropagation) {
                event.stopPropagation();
            }
            event.preventDefault();
            console.log("Closing tab", Date.now());
        },

        stopTimer() {
            clearInterval(this.timer);
            this.timer = null;
            window.onbeforeunload = null;
            window.onblur = null;
        },
        async completeExam() {
            // confirm here
            this.stopTimer();
            this.resetExam();
            this.closeExamPreview();
        },
        startExam() {
            this.viewMode = 'exam-session';
            this.startTimer();
        },
        resetExam() {
            this.startTime = null;
            this.timeLeft = null;
            this.timeTaken = null;
            this.activeQuestionIndex = 0;
            this.questions = [];
            this.answeredQuestions = [];
            this.examInfo = null;
            this.viewMode = 'instructions';
        },
        nextQuestion() {
            let index = this.activeQuestionIndex + 1;
            if (index >= this.questions.length) {
                return;
            }
            this.activeQuestionIndex = index;
        },
        previousQuestion() {
            let index = this.activeQuestionIndex - 1;
            if (index < 0) {
                return;
            }
            this.activeQuestionIndex = index;
        },
        setActiveQuestion(index) {
            this.activeQuestionIndex = index;
        },
        setAnsweredQuestion(questionId) {
            let question = this.questions.find((question) => question.id === questionId);
            if (!question) {
                return;
            }
            let index = this.answeredQuestions.indexOf(questionId);
            let isAttempted = question.answers.some(answer => {
                return !!answer.selected;
            });
            console.log(question, index, isAttempted);
            if (index === -1) {
                if (isAttempted) {
                    this.answeredQuestions.push(questionId);
                }
            } else {
                if (!isAttempted) {
                    this.answeredQuestions.splice(index, 1);
                }
            }
        },
    }
}
</script>

<style scoped>

</style>
