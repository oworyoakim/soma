<template>
    <!-- ****** -->
    <v-layout>
        <template v-if="isLoading">
            <v-progress-circular class="ml-10" color="primary" indeterminate/>
        </template>
        <v-flex v-else>
            <v-container class="pa-2 text-center">
                <v-row class="fill-height" align="center" justify="start">
                    <template v-for="(course, i) in courses">
                        <v-col :key="i" cols="12" md="4">
                            <v-hover v-slot:default="{ hover }">
                                <v-card :elevation="hover ? 12 : 1" :class="{ 'on-hover': hover }">
                                    <v-img :src="course.thumbnail" height="225px">
                                        <v-card-title class="title white--text">
                                            <v-row class="fill-height flex-column" justify="space-between">
                                                <p class="mt-4 font-weight-bold heading text-left">{{ course.title }}</p>
                                                <div>
                                                    <v-row justify="start">
                                                        <v-icon
                                                            class="ml-4"
                                                            color="white"
                                                        >schedule
                                                        </v-icon
                                                        >
                                                        <span
                                                            class="subheading font-weight-bold mr-4"
                                                        >Duration:</span
                                                        >
                                                        <span
                                                        >{{
                                                                course.duration
                                                            }}
                                                            mins</span
                                                        >
                                                    </v-row>
                                                </div>
                                            </v-row>
                                        </v-card-title>
                                    </v-img>
                                    <v-fade-transition>
                                        <v-overlay
                                            v-if="hover"
                                            absolute
                                            color="#036358"
                                        >
                                            <v-btn @click="viewCourse(course)">
                                                <b>View Course</b>
                                            </v-btn>
                                            <v-btn @click="confirmTakeExam(course)">
                                                <b>Take Exam</b>
                                            </v-btn>
                                        </v-overlay>
                                    </v-fade-transition>
                                </v-card>
                            </v-hover>
                        </v-col>
                    </template>
                </v-row>
            </v-container>
            <!-- **** -->
            <!-- start of exam module -->
            <div class="text-center">
                <v-dialog v-model="takeExam" persistent width="500">
                    <v-card>
                        <v-card-title class="title grey lighten-2">Confirm
                        </v-card-title>
                        <v-card-text class="subtitle">
                          <br />
                          Are you sure you want to Complete the
                          <b>Exam</b> now?
                      </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" outlined @click="clearCourseForExam">Cancel
                            </v-btn>
                            <v-btn color="primary" @click="goToExamPage()">Continue</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-flex>
    </v-layout>
</template>
<script>
    import {mapGetters} from "vuex";
    import {baseUrl} from "../../app";

    export default {
        computed: {
            ...mapGetters({
                courses: "COURSES",
                isLoading: "LOADING",
            })
        },
        data() {
            return {
                takeExam: false,
                courseForExam: null,
                transparent: "rgba(255, 255, 255, 0)"
            };
        },
        methods: {
            viewCourse(course) {
                this.$store.dispatch("SET_ACTIVE_COURSE", course);
                this.$nextTick(() => {
                    this.$router.push({
                        name: "course-details",
                        params: {slug: course.slug}
                    });
                });
            },
            confirmTakeExam(course) {
                this.courseForExam = course;
                this.takeExam = true;
            },
            goToExamPage() {
                this.takeExam = false;
                if (this.courseForExam) {
                    let url = baseUrl + "/exam/" + this.courseForExam.slug;
                    let win = window.open(url, "_blank");
                    win.focus();
                }
            },
            clearCourseForExam() {
                this.courseForExam = null;
                this.takeExam = false;
            }
        }
    };
</script>
<style scoped>
</style>
