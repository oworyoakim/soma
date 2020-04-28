<template>
  <v-layout row wrap>
    <v-row>
      <v-col cols="12" class="sm12 ml-2">

        <v-data-table
            :headers="headers"
            :items="answers"
            :search="search"
            sort-by="answer"
            class="elevation-1"
        >
        <template v-slot:top>
                <v-toolbar flat color="white">
                    <h2 class="mr-1">Answers</h2>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label="Search"
                      single-line
                      hide-details
                    ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="800px">
                            <template v-slot:activator="{}">
                                <v-btn color="primary" dark class="mb-2" @click="editItem()">Add New</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field required v-model="editedItem.answer" label="Answer"></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" class="d-flex sm12">
                                                <v-select required :items="items" label="Correct"></v-select>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn color="warning" dark class="mb-2" @click="close">Cancel</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" dark class="mb-2" @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
        </v-col>
        </v-row>
  </v-layout>
</template>

<script>

  export default {
    data: () => ({
      dialog: false,
      search: '',
      text: '',
      items: ['Yes', 'No',],
      statuses: ['Active', 'Inactive',],
      headers: [
        { text: 'Answer', value: 'answer' },
        { text: 'Correct', value: 'correct' },
        { text: 'Status', value: 'status' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      answers: [],
      editedIndex: -1,
      editedItem: {
        answer: '',
        correct: '',
        status: true,
      },
      defaultItem: {
        answer: 'answer',
        correct: 'yes',
        status: false,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Add Answer' : 'Edit Answer'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.answers = [
          {
            answer: 'Answer 1.',
            correct: 'yes',
            status: true,
          },
          {
            answer: 'Answer 2.',
            correct: 'no',
            status: false,
          },
          {
            answer: 'Answer 3.',
            correct: 'no',
            status: false,
          },
          {
            answer: 'Answer 4.',
            correct: 'yes',
            status: true,
          },
          {
            answer: 'Answer 5.',
            correct: 'no',
            status: false,
          },
          {
            answer: 'Answer 6.',
            correct: 'yes',
            status: true,
          },
        ]
      },

      editItem (item) {
        this.editedIndex = this.answers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.answers.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.answers.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {

        if (this.editedIndex > -1) {
          Object.assign(this.answers[this.editedIndex], this.editedItem)
        } else {
          this.answers.push(this.editedItem)
        }
        this.close()
      }
    },
  }
</script>
