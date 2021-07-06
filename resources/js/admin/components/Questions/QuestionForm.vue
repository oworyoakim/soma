<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <ul class="nav nav-tabs nav-justified mb-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#question_description"
                           data-toggle="tab">
                            The Question
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#question_answers"
                           data-toggle="tab">
                            Answers
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2">
                    <div class="tab-pane active" id="question_description">
                        <div class="form-group row">
                            <label class="col-md-3">Title</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="question.title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Type</label>
                            <div class="col-md-9">
                                <select v-model="question.type" class="form-control">
                                    <option value="">Select...</option>
                                    <option v-for="type in questionTypes" :value="type.value">
                                        {{ type.text }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Weight (Mark)</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" min="0" v-model="question.weight">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-6">Shuffle Answers</label>
                            <div class="col-6">
                                <input type="checkbox" class="form-check-input" v-model="question.shuffleAnswers">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Question</label>
                            <TinymceEditor
                                v-model="question.description"
                                :api-key="$store.getters.TINYMCE_API_KEY"
                                :init="{...$store.getters.EDITOR_CONFIG,height: 200}"
                            />
                        </div>
                    </div>
                    <div class="tab-pane" id="question_answers">
                        <div class="form-group row border-bottom my-2 py-2" v-for="answer in question.answers">
                            <div class="col-md-8 col-sm-12">
                                <TinymceEditor
                                    v-model="answer.description"
                                    :api-key="$store.getters.TINYMCE_API_KEY"
                                    :init="{...$store.getters.EDITOR_CONFIG,  height: 200, placeholder: 'Enter the answer.'}"
                                />
                            </div>
                            <div class="col-md-3 col-sm-10 col-xs-10">
                                <label class="checkbox-inline ml-5">
                                    <input type="checkbox" class="form-check-input" v-model="answer.correct">
                                    Is correct?
                                </label>
                            </div>
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <button class="btn btn-danger btn-sm" title="Remove Answer" type="button"
                                        @click="removeAnswer(answer)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-sm float-right" title="Add Answer" type="button"
                                    @click="addAnswer()">
                                Add Answer
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveQuestion()" type="button" :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Save</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import {mapGetters} from "vuex";
import MainModal from "../../../shared/components/MainModal";
import {Question} from "../../../models/Question";
import {deepClone} from "../../../shared/utils/helpers";
import {Answer} from "../../../models/Answer";

export default {
    components: {
        MainModal,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    computed: {
        ...mapGetters({
            module: "ACTIVE_MODULE",
            topic: "ACTIVE_TOPIC",
        }),
        title() {
            return !!this.question.id ? "Edit Question" : "New Question";
        },
        someAnswersAreInvalid() {
            return this.question.answers.some((answer, index) => !!!answer.description);
        },
        formInvalid() {
            return this.isSending ||
                !!!this.question.title ||
                !!!this.question.type ||
                this.someAnswersAreInvalid;
        },
    },
    data() {
        return {
            question: new Question(),
            isEditing: false,
            isSending: false,
            questionTypes: [
                {text: "Revision", value: "revision"},
                {text: "Exam", value: "exam"},
                {text: "Both", value: "both"},
            ],
        }
    },
    created() {
        EventBus.$on(["EDIT_QUESTION"], this.editQuestion);
    },
    methods: {
        editQuestion(question = null) {
            if (question) {
                this.question = deepClone(question);
            } else {
                this.question = new Question();
            }
            if (this.question.answers.length === 0) {
                this.addAnswer(4);
            }
            this.isEditing = true;
        },
        addAnswer(count = 1) {
            for (let i = 1; i <= count; i++) {
                let answer = new Answer();
                this.question.answers.push(answer);
            }
        },
        removeAnswer(answer) {
            let index = this.question.answers.indexOf(answer);
            this.question.answers = this.question.answers.filter((ans, i) => i !== index || ans !== answer);
        },
        async saveQuestion() {
            try {
                this.isSending = true;
                if (!this.question.moduleId) {
                    this.question.moduleId = this.module.id;
                }
                if (!this.question.topicId) {
                    this.question.topicId = this.topic.id;
                }
                let response = await this.$store.dispatch("SAVE_QUESTION", this.question);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("QUESTION_SAVED");
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.question = new Question();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
