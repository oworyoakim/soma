<template>
    <v-layout row wrap>
        <template v-if="isLoading">
            <v-progress-circular class="ml-10" color="primary" indeterminate/>
        </template>
        <template v-else-if="!!course">
            <v-flex xs12 sm6 md6 lg8 xl8 class="mx-5">
                <v-toolbar color="indigo lighten-1" dark flat>
                    <v-toolbar-title>{{course.title}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-tabs v-model="tabs" centered>
                        <v-tab v-for="detail in tabItems" :key="detail">{{ detail }}</v-tab>
                    </v-tabs>
                </v-toolbar>
                <v-tabs-items v-model="tabs">
                    <v-tab-item>
                        <v-row>
                            <v-col cols="12">
                                <v-card flat>
                                    <v-card-title>
                                        What this course is about
                                        <v-spacer></v-spacer>
                                        <v-avatar @click="editContent('description')">
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-avatar>
                                    </v-card-title>
                                    <v-card-text v-html="course.description"></v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-card flat>
                                    <v-card-title>
                                        What you will cover in this course
                                        <v-spacer></v-spacer>
                                        <v-avatar @click="editContent('outline')">
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-avatar>
                                    </v-card-title>
                                    <v-card-text v-html="course.outline"></v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-card flat>
                                    <v-card-title>
                                        What your are expected to know after completing this course
                                        <v-spacer></v-spacer>
                                        <v-avatar @click="editContent('outcome')">
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-avatar>
                                    </v-card-title>
                                    <v-card-text v-html="course.outcome"></v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-tab-item>
                    <v-tab-item>
                        <template v-if="course.modules.length > 0">
                            <v-carousel class cycle height="300" hide-delimiter-background
                                        show-arrows-on-hover>
                                <v-carousel-item v-for="(slide, i) in slides" :key="i">
                                    <v-sheet :color="colors[i]" height="100%">
                                        <v-row class="fill-height mx-auto" align="center" justify="center">
                                            <div class="display-4 mb-l2">
                                                <span class=".subtitle-2">{{i+1}}</span>
                                                . {{slide.title }}
                                            </div>
                                        </v-row>
                                    </v-sheet>
                                </v-carousel-item>
                            </v-carousel>

                            <v-stepper v-if="course.modules.length > 0" v-model="e6" vertical>
                            <span v-for="(module, index) in course.modules" :key="module.id">
                              <v-stepper-step :step="index+1">
                                <span>{{module.title}}</span>
                              </v-stepper-step>
                              <v-stepper-content :step="index+1">
                                <v-card color="grey lighten-5" class="mb-12" height="auto" max-width="auto">
                                  <v-card-title>About {{module.title}}</v-card-title>
                                  <v-card-text>
                                    <p class="text-justify thin">{{module.description}}</p>
                                    <p>It has {{module.topics.length}} topics</p>
                                  </v-card-text>
                                </v-card>
                                <v-btn v-if="index > 0" color="primary" @click="e6 = index">Back</v-btn>
                                <v-btn
                                    v-if="index+1 === course.modules.length"
                                    color="primary"
                                    @click="CompleteDialog=true"
                                >Complete</v-btn>
                                <v-btn v-else color="primary" @click="e6 = index+2">Next</v-btn>
                                <v-btn color="primary" @click="viewModule(module)">View Module</v-btn>
                              </v-stepper-content>
                            </span>
                            </v-stepper>
                        </template>
                    </v-tab-item>
                </v-tabs-items>
                <template v-if="!!isEditing">
                    <v-row justify="center">
                        <v-dialog persistent v-model="isEditing" scrollable width="800px">
                            <v-card>
                                <v-card-title>
                                    <span class="headline">Editing Course {{editMode}}</span>
                                </v-card-title>
                                <v-card-text>
                                    <app-rich-text-editor
                                        v-model="course[editMode]"
                                        :value="course[editMode]"
                                        :placeholder="`Enter ${editMode}`"/>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" outlined @click="closeContentModal()">Cancel</v-btn>
                                    <v-btn color="primary" @click="updateCourseContent">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-row>
                </template>
            </v-flex>
            <v-flex xs12 sm4 md4 lg3 xl3 course>
                <v-card class="mx-auto" max-width="370">
                    <v-card-text>
                        <div>
                            <h4 class="font-weight-bold"></h4>Course Details Summary
                        </div>
                        <v-list-item title="Instructor">
                            <v-list-item-avatar>
                                <v-img src="/images/avatar.png"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Instructor</v-list-item-subtitle>
                                <v-list-item-title>John Doe Doe Doe Doe</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-timer</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Duration</v-list-item-subtitle>
                                <v-list-item-title>Expected to last {{course.duration}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <br/>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-room-service</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Course Weight</v-list-item-subtitle>
                                <v-list-item-title>{{course.weight}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-menu</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Numbers Enrolled</v-list-item-subtitle>
                                <v-list-item-title>{{course.numEnrolled}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card-text>
                </v-card>
                <br/>
                <v-card class="mx-auto" max-width="370">
                    <v-card-text>
                        <div>
                            <h4 class="font-weight-bold"></h4>Enrollment History
                        </div>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-timer</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Enrolled On</v-list-item-subtitle>
                                <v-list-item-title>February 20, 2020</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-timer</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>First Exam Attended</v-list-item-subtitle>
                                <v-list-item-title>February 23, 2020</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-autorenew</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Number of Exams Taken</v-list-item-subtitle>
                                <v-list-item-title>4</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon color="grey lighten-1">mdi-warning</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle>Status</v-list-item-subtitle>
                                <v-list-item-title>Pass/Failed/Retaking/In-Progress</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn text color="deep-purple accent-2" @click="addModule">Add Module</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <!-- Completion Modal design -->
            <v-row justify="center">
                <v-dialog v-model="dialog" persistent max-width="290">
                    <v-card>
                        <v-card-title class="headline">Use Google's location service?</v-card-title>
                        <v-card-text>Let Google help apps determine location. This means sending anonymous location data
                            to
                            Google, even when no apps are running.
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialog = false">Disagree</v-btn>
                            <v-btn color="green darken-1" text @click="dialog = false">Agree</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
            <!-- Adding New module -->
            <v-row justify="center">
                <v-dialog v-model="moduleModal" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Add Module</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <v-text-field label="Name*" v-model="activeModule.title"
                                                      required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-text-field label="Duration*" v-model="activeModule.duration" type="number"
                                                      required></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea
                                            label="Description"
                                            v-model="activeModule.description"
                                            auto-grow
                                            outlined
                                            rows="3"
                                            row-height="25"
                                        ></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" outlined @click="closeCourseModuleModal">Cancel</v-btn>
                            <v-btn color="primary" @click="saveCourseModule">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
            <div class="text-center">
                <v-dialog v-model="CompleteDialog" width="500">
                    <v-card>
                        <v-card-title class="headline grey lighten-2" primary-title>Confirm Completion</v-card-title>

                        <v-card-text>Are you Sure you would like to submit this course as completed?</v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="CompleteDialog = false">Cancel</v-btn>
                            <v-btn color="primary" text @click="CompleteDialog = false">Yes</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </template>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";
    import CourseModule from "../../../models/CourseModule";

    let StepperValue = 1;
    export default {
        mounted() {

        },
        computed: {
            ...mapGetters({
                courses: 'COURSES',
                course: "ACTIVE_COURSE",
                isLoading: "LOADING",
            }),
            slides() {
                if (this.course.modules.length > 0) {
                    return this.course.modules;
                }
                return [];
            }
        },
        watch: {
            isLoading(newValue, oldValue) {
                if (!newValue) {
                    if (!this.$store.state.activeCourse) {
                        let slug = this.$route.params.slug;
                        console.log(slug);
                        let course = this.courses.find(c => c.slug === slug);
                        if (course) {
                            this.$store.dispatch('SET_ACTIVE_COURSE', course);
                        } else {
                            this.$router.push({name: 'admin-courses-list'});
                        }
                    }
                }
            },
        },
        data() {
            return {
                dialog: false,
                isEditing: false,
                editMode: null,
                moduleModal: false,
                activeModule: new CourseModule(),
                CompleteDialog: false,
                colors: [
                    "indigo",
                    "pink darken-4",
                    "red darken-5",
                    "deep-purple accent-4"
                ],
                e6: 1,
                tabs: null,
                tabItems: ["Overview", "Modules"],
            };
        },

        methods: {
            allModules(courseDetail) {
                courseDetail.map = item => {
                    this.slides.push(item.title);
                };
            },
            viewModule(module) {
                this.$store.dispatch("SET_ACTIVE_MODULE",module);
                this.$nextTick(() => {
                    this.$router.push({
                        name: "admin-course-module-details",
                        params: {slug: this.course.slug, moduleId: module.id}
                    });
                });
            },
            addModule() {
                this.moduleModal = true;
                this.activeModule.courseId = this.course.id;
            },
            async saveCourseModule() {
                try {
                    let response = await this.$store.dispatch("SAVE_MODULE", this.activeModule);
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    this.closeCourseModuleModal();
                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                }
            },
            async updateCourseContent() {
                try {
                    let response = await this.$store.dispatch("SAVE_COURSE", this.course);
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    this.closeContentModal();
                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                }
            },
            closeCourseModuleModal() {
                this.moduleModal = false;
                this.activeModule = new CourseModule();
            },
            viewModuleComplete(module) {
                alert("Succescful completed");
            },
            editContent(mode) {
                this.editMode = mode;
                this.isEditing = true;
            },
            closeContentModal() {
                this.editMode = null;
                this.isEditing = false;
            },
        }
    };
</script>
<style scoped>
</style>
