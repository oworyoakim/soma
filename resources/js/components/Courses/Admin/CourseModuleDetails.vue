<template>
    <v-layout>
        <template v-if="isLoading">
            <v-progress-circular class="ml-10" color="primary" indeterminate/>
        </template>
        <template v-else-if="!!module">
        <v-card id="create">
            <v-toolbar color="indigo lighten-1" dark flat>
                <v-toolbar-title>{{module.title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tabs v-model="tabs" centered>
                    <v-tab v-for="detail in items" :key="detail">{{ detail }}</v-tab>
                </v-tabs>
            </v-toolbar>
            <v-tabs-items v-model="tabs">
                <!-- module Overview tab content -->
                <v-tab-item>

                </v-tab-item>
                <!-- topics tab content -->
                <v-tab-item>
                    <app-admin-topics
                        :topics.sync="module.topics"
                        :module-id="module.id"
                    />
                </v-tab-item>
                <!-- questions tab content-->
                <v-tab-item>
                    <app-admin-questions
                        :questions.sync="module.questions"
                        :module-id="module.id"
                    />
                </v-tab-item>
                <!-- materials tab -->
                <v-tab-item>
                    <v-card flat>
                        <v-card-title class="headline">An awesome material</v-card-title>
                        <v-card-text>

                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
        </template>
    </v-layout>
</template>
<script>
    import {mapGetters} from "vuex";
    import {EventBus} from "../../../app";
    import Question from "../../../models/Question";

    export default {
        data() {
            return {
                items: ["Overview", "Topics", "Questions", "Materials"],
                addTopic: false,
                currentItem: "tab-Web",
                direction: "top",
                fab: false,
                fling: false,
                hover: true,
                tabs: null,
                top: false,
                right: true,
                bottom: true,
                left: false,
                transition: "slide-y-reverse-transition",
                isOpen: false,
                activeQuestion: null,
                text: "Lorem ipsum dolor sit amet, consectetur ",
                search: "",
                headers: [
                    {text: "Question", value: "question"},
                    {text: "Description", value: "description"},
                    {text: "Weight", value: "weight"},
                    {text: "Active", value: "active"},
                    {text: "Actions", value: "action", sortable: false}
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    question: "",
                    description: "",
                    weight: 0,
                    active: true
                },
                defaultItem: {
                    question: "Question 1.",
                    description: "How do you initiate a flight?",
                    weight: 2,
                    active: false
                }
            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? "Add Question" : "Edit Question";
            },
            ...mapGetters({
                courses: 'COURSES',
                course: 'ACTIVE_COURSE',
                module: 'ACTIVE_MODULE',
            }),
            isLoading() {
                return this.$store.state.isLoading;
            },
        },

        watch: {
            isLoading(newValue, oldValue) {
                if (!newValue && !this.$store.state.activeCourse) {
                    let slug = this.$route.params.slug;
                    console.log(slug);
                    let course = this.courses.find(c => c.slug === slug);
                    if (course) {
                        this.$store.dispatch('SET_ACTIVE_COURSE', course);
                        let moduleId = this.$route.params.moduleId;
                        let module = course.modules.find(m => m.id == moduleId);
                        if (module) {
                            this.$store.dispatch('SET_ACTIVE_MODULE', module);
                        } else {
                            this.$router.push({name: 'admin-course-details', params: {slug: course.slug}});
                        }
                    } else {
                        this.$router.push({name: 'admin-courses-list'});
                    }
                }
            },
            dialog(val) {
                val || this.close();
            }
        },

        mounted() {

        },
        methods: {
            initialize() {
                this.desserts = [
                    {
                        question: "Question 1.",
                        description:
                            "How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight? How do you initiate a flight?",
                        weight: 2,
                        active: false,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "yes",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "yes",
                                status: true
                            }
                        ]
                    },
                    {
                        question: "Question 2.",
                        description: "How do you initiate a flight?",
                        weight: 2,
                        active: false,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "yes",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "yes",
                                status: true
                            }
                        ]
                    },
                    {
                        question: "Question 3.",
                        description: "How do you initiate a flight?",
                        weight: 2,
                        active: true,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "yes",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "yes",
                                status: true
                            }
                        ]
                    },
                    {
                        question: "Question 4.",
                        description: "How do you initiate a flight?",
                        weight: 2,
                        active: false,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "no",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "yes",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "no",
                                status: true
                            }
                        ]
                    },
                    {
                        question: "Question 5.",
                        description: "How do you initiate a flight?",
                        weight: 2,
                        active: false,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "no",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "yes",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "no",
                                status: true
                            }
                        ]
                    },
                    {
                        question: "Question 6.",
                        description: "How do you initiate a flight?",
                        weight: 2,
                        active: true,
                        children: [
                            {
                                answer: "Answer 1.",
                                correct: "yes",
                                status: true
                            },
                            {
                                answer: "Answer 2.",
                                correct: "no",
                                status: false
                            },
                            {
                                answer: "Answer 3.",
                                correct: "yes",
                                status: false
                            },
                            {
                                answer: "Answer 4.",
                                correct: "no",
                                status: true
                            }
                        ]
                    }
                ];
            },
            showdialog2(item) {
                this.editedIndex = this.desserts.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog2 = true;
            },

            editItem(item) {
                this.editedIndex = this.desserts.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },

            deleteItem(item) {
                const index = this.desserts.indexOf(item);
                confirm("Are you sure you want to delete this item?") &&
                this.desserts.splice(index, 1);
            },

            close() {
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                }, 300);
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem);
                } else {
                    this.desserts.push(this.editedItem);
                }
                this.close();
            },
        }
    };
</script>
<style>
    /* This is for documentation purposes and will not be needed in your application */
    #create {
        width: 100%;
    }

    #create .v-speed-dial {
        position: absolute;
    }

    #create .v-btn--floating {
        position: relative;
    }
</style>
