<template>
    <v-layout row wrap class="admin-courses-list">
        <v-row>
            <v-col cols="12" class="sm12 ml-2">
                <v-data-table
                    :headers="headers"
                    :items="courses"
                    :search="search"
                    loading-text="Loading..."
                    sort-by="title"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <h2 class="mr-1">Courses</h2>
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" dark class="mb-2" @click="editCourse()">Add New</v-btn>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small class="mr-2" @click="viewCourse(item)">mdi-eye</v-icon>
                        <v-icon small class="mr-2" @click="editCourse(item)">mdi-pencil</v-icon>
                        <v-icon small @click="deleteCourse(item)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <app-course-form/>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";
    import Course from "../../../models/Course";
    import {EventBus} from "../../../app";

    export default {
        data() {
            return {
                activeCourse: new Course(),
                search: '',
                headers: [
                    {text: 'Code', align: 'start', sortable: false, value: 'code'},
                    {text: 'Title', value: 'title'},
                    {text: 'Duration', value: 'duration'},
                    {text: 'Modules', value: 'numModules'},
                    {text: 'Weight', value: 'weight'},
                    {text: 'Total Enrolled', value: 'numEnrolled'},
                    {text: 'Actions', value: 'action', sortable: false},
                ],
            }
        },

        computed: {
            ...mapGetters({
                courses: 'COURSES',
            }),
        },

        methods: {
            viewCourse(course) {
                this.$store.dispatch('SET_ACTIVE_COURSE', course);
                this.$nextTick(() => {
                    this.$router.push({
                        name: 'admin-course-details',
                        params: {slug: course.slug}
                    });
                });
            },
            editCourse(course = null) {
                EventBus.$emit('EDIT_COURSE',course);
            },

            deleteCourse(course) {
                const index = this.courses.indexOf(course);
                confirm('Are you sure you want to delete this item?') && this.courses.splice(index, 1);
            },
        },
    }
</script>
