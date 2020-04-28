<template>
  <v-layout row wrap>
    <v-row>
      <v-col cols="12" class="sm12 ml-2">
        <v-data-table
          :headers="headers"
          :items="questions"
          :search="search"
          sort-by="id"
          class="elevation-1"
          dense
        >
          <template v-slot:top>
            <v-toolbar flat color="white">
              <h2 class="mr-1">Questions</h2>
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search"
                append-icon="search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
              <v-spacer></v-spacer>
              <v-dialog v-model="isQuestionFormOpen" max-width="800px">
                <template v-slot:activator="{}">
                  <v-btn color="primary" dark class="mb-2" @click="editQuestion()">Add New</v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field required v-model="question.title" label="Question"></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field required v-model="question.type" label="Weight"></v-text-field>
                        </v-col>
                      </v-row>

                      <v-row>
                        <v-col cols="12">
                          <label>Description</label>
                          <app-rich-text-editor
                            v-model="question.description"
                            placeholder="Enter a description of what the question tests."
                          />
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer />
                    <v-btn
                      color="primary"
                      outlined
                      dark
                      class="mb-2"
                      @click="closeQuestionForm"
                    >Cancel</v-btn>
                    <v-btn color="primary" dark class="mb-2" @click="saveQuestion">Save</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small @click="openQuestionModal(item)" class="mr-5">remove_red_eye</v-icon>
            <v-icon small @click="editQuestion(item)" class="mr-5">mdi-pencil</v-icon>
            <v-icon small @click="deleteQuestion(item)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
    <template v-if="!!activeQuestion">
      <app-main-modal :is-open.sync="isOpen" @close-modal="closeQuestionModal">
        <v-card flat class="justify-center">
          <v-list three-line subheader>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>{{activeQuestion.title}}</v-list-item-title>
                <v-list-item-subtitle>{{activeQuestion.description}}</v-list-item-subtitle>
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
          <app-answer-form v-if="!!activeQuestion" :question-id="activeQuestion.id" />
        </v-card>
      </app-main-modal>
    </template>
  </v-layout>
</template>

<script>
import { EventBus } from "../../app";
import { mapGetters } from "vuex";
import Question from "../../models/Question";

export default {
  data: () => ({
    isOpen: false,
    isQuestionFormOpen: false,
    questions: [],
    activeQuestion: null,
    question: new Question(),
    search: "",
    text: "",
    headers: [
      { text: "Question", value: "title" },
      { text: "Weight", value: "weight" },
      { text: "Active", value: "active" },
      { text: "Actions", value: "action", sortable: false }
    ]
  }),

  computed: {
    formTitle() {
      return !!this.question.id ? "Edit Question" : "Add Question";
    }
  },

  created() {
    this.getQuestions();
  },

  methods: {
    async getQuestions() {
      try {
        let response = await this.$http.get("/v1/questions");
        this.questions = response.data;
      } catch (error) {
        console.log(error);
      }
    },
    openQuestionModal(question) {
      this.activeQuestion = question;
      this.isOpen = true;
    },
    closeQuestionModal() {
      this.isOpen = false;
      this.activeQuestion = null;
    },

    editQuestion(question = null) {
      if (!!question) {
        this.question = question;
      } else {
        this.question = new Question();
      }
      this.isQuestionFormOpen = true;
    },

    deleteQuestion(question) {},

    async saveQuestion() {
      try {
      } catch (error) {
        console.log(error);
      }
    },
    editAnswer(answer = null) {
      EventBus.$emit("EDIT_ANSWER", answer);
    },
    closeQuestionForm() {
      this.question = new Question();
      this.isQuestionFormOpen = false;
    }
  }
};
</script>
