<template>
    <v-dialog persistent v-model="isOpen" max-width="800px">
        <v-card>
            <v-card-title>
                <span v-if="answer.id" class="headline">Edit Answer</span>
                <span v-else class="headline">Add Answer</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field required v-model="answer.title" label="Answer"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="d-flex sm12">
                            <v-checkbox v-model="answer.correct" required label="Correct"/>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer/>
                <v-btn color="primary" outlined dark class="mb-2" @click="closeForm">Cancel</v-btn>
                <v-btn :disabled="isSending || !answer.title.trim()" color="primary" dark class="mb-2" @click="saveAnswer">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Answer from "../../../models/Answer";
    import {EventBus} from "../../../app";

    export default {
        props: {
            questionId: Number,
        },
        created() {
            EventBus.$on(["ADD_ANSWER", "EDIT_ANSWER"], this.openForm);
        },
        data() {
            return {
                answer: new Answer(),
                isOpen: false,
                isSending: false,
            }
        },
        methods: {
            async saveAnswer() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_ANSWER", this.answer);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: response});
                    this.closeForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: error,context: 'error'});
                }
            },
            openForm(answer = null) {
                if (!!answer) {
                    this.answer = answer;
                } else {
                    this.answer = new Answer();
                    this.answer.questionId = this.questionId;
                }
                this.isOpen = true;
            },
            closeForm() {
                this.answer = new Answer();
                this.answer.questionId = this.questionId;
                this.isOpen = false;
            }
        }
    }
</script>

<style scoped>

</style>
