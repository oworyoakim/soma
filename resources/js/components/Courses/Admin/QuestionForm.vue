<template>
    <v-dialog persistent v-model="isOpen" max-width="800px">
        <v-card>
            <v-card-title>
                <span v-if="question.id" class="headline">Edit Question</span>
                <span v-else class="headline">Add Question</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-textarea
                                label="Objective"
                                v-model="question.description"
                                auto-grow
                                outlined
                                rows="2"
                                row-height="10"
                                placeholder="Enter a description of what the question tests"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-select
                                :items="questionTypes"
                                item-value="value"
                                item-text="text"
                                :rules="[v => !!v || 'Question type is required']"
                                label="Type"
                                v-model="question.type"
                                required
                            ></v-select>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <label>The Question</label>
                            <app-rich-text-editor
                                v-model="question.title"
                                :value="question.title"
                                placeholder="Enter the question."
                            />
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="primary" outlined dark class="mb-2" @click="closeForm">Cancel</v-btn>
                <v-btn :disabled="isSending || !question.title.trim()" color="primary" dark class="mb-2" @click="saveQuestion">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {EventBus} from "../../../app";
    import Question from "../../../models/Question";

    export default {
        props: {
            moduleId: {type: Number, required: true},
            topicId: {type: Number, required: true},
        },
        created() {
            EventBus.$on(["ADD_QUESTION", "EDIT_QUESTION"], this.openForm);
        },
        data() {
            return {
                question: new Question(),
                questionTypes: [
                    {text: "Revision", value: "revision"},
                    {text: "Exam", value: "exam"},
                    {text: "Both", value: "both"},
                ],
                isOpen: false,
                isSending: false,
            }
        },
        methods: {
            async saveQuestion() {
                try {
                    this.isSending = true;
                    if(!this.question.moduleId) {
                        this.question.moduleId = this.moduleId;
                    }
                    if(!this.question.topicId) {
                        this.question.topicId = this.topicId;
                    }
                    let response = await this.$store.dispatch("SAVE_QUESTION", this.question);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: response});
                    this.closeForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: error,context: 'error'});
                }
            },
            openForm(question = null) {
                if (!!question) {
                    this.question = question;
                } else {
                    this.question = new Question();
                    this.question.moduleId = this.moduleId;
                    this.question.topicId = this.topicId;
                }
                this.isOpen = true;
            },
            closeForm() {
                this.question = new Question();
                this.question.moduleId = this.moduleId;
                this.question.topicId = this.topicId;
                this.isOpen = false;
            }
        }
    }
</script>

<style scoped>

</style>
