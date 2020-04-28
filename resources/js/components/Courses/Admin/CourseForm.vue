<template>
    <v-dialog persistent v-model="isOpen" max-width="800px">
        <v-card>
            <v-card-title>
                <span v-if="course.id" class="headline">Edit Course</span>
                <span v-else class="headline">Add Course</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field required v-model="course.code"
                                          label="Code"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field required v-model="course.title"
                                          label="Title"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field required v-model="course.duration"
                                          label="Duration (in mins)"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field required v-model="course.weight"
                                          label="Weight (credit units)"></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="primary" outlined dark class="mb-2" @click="closeForm">Cancel</v-btn>
                <v-btn :disabled="isSending || !course.title.trim()" color="primary" class="mb-2" @click="saveCourse">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {EventBus} from "../../../app";
    import Course from "../../../models/Course";

    export default {
        props: {

        },
        created() {
            EventBus.$on(["ADD_COURSE", "EDIT_COURSE"], this.openForm);
        },
        data() {
            return {
                course: new Course(),
                isOpen: false,
                isSending: false,
            }
        },
        methods: {
            async saveCourse() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_COURSE", this.course);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: response});
                    this.closeForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: error,context: 'error'});
                }
            },
            openForm(course = null) {
                if (!!course) {
                    this.course = course;
                } else {
                    this.course = new Course();
                }
                this.isOpen = true;
            },
            closeForm() {
                this.course = new Course();
                this.isOpen = false;
            }
        }
    }
</script>

<style scoped>

</style>
