<template>
    <v-layout row wrap class="admin-exams-list">
        <v-row>
            <v-col cols="12" class="sm12 ml-2">
                <v-data-table
                    :headers="headers"
                    :items="exams"
                    :search="search"
                    loading-text="Loading..."
                    sort-by="title"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <h2 class="mr-1">Exams</h2>
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" dark class="mb-2" @click="editExam()">Add New</v-btn>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small class="mr-2" @click="editExam(item)">mdi-pencil</v-icon>
                        <v-icon small @click="deleteExam(item)">mdi-delete</v-icon>
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

    export default {
        data() {
            return {
                activeExam: new Exam(),
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
                exams: 'EXAMS',
            }),
        },
    }
</script>

<style scoped>

</style>
