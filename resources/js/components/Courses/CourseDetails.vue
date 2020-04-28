<template>
  <v-layout row wrap>
    <template v-if="isLoading">
      <v-progress-circular class="ml-10" color="primary" indeterminate />
    </template>
    <template v-else-if="!!course">
      <!-- ********************** -->
      <v-flex xs12 sm12 md12 lg12 xl12>
        <!-- carousel begins -->
        <v-carousel
          v-model="model"
          class="mx-auto ml-2"
          cycle
          height="300"
          hide-delimiter-background
          show-arrows-on-hover
        >
          <v-carousel-item v-for="(slide, i) in slides" :key="i">
            <v-sheet :color="colors[i]" height="100%">
              <v-row class="fill-height mx-auto" align="center" justify="center">
                <div class="display-4 mb-l2">
                  <span class=".subtitle-6">{{ i + 1 }}</span>
                  . {{ slide.title }}
                </div>
              </v-row>
            </v-sheet>
          </v-carousel-item>
        </v-carousel>
        <!-- end ofcarousel display -->
        <v-hover>
          <template v-slot:default="{ hover }">
            <v-card class="mx-auto ml-4">
              <template>
                <v-btn text color="deep-purple accent-4">
                  <v-card-title>{{ course.title }}</v-card-title>
                </v-btn>
              </template>
              <v-card-text class="d-inline-flex justify-space-around">
                <v-card class="pa-4 elevation-0" width="400">
                  <v-timeline dense>
                    <v-timeline-item small fill-dot color="grey" icon-color="grey lighten-2">
                      <template>
                        <v-btn text color="deep-purple accent-4">Description</v-btn>
                      </template>
                      <v-card class="elevation-2" height="130">
                        <v-card-text v-if="text.length > 100">
                          {{ text.substring(0, 100) }} . .
                          .
                          <br />
                          <a color="blue">click to read more</a>
                        </v-card-text>
                        <v-card-text v-else>
                          {{
                          text.description
                          }}
                        </v-card-text>
                      </v-card>
                    </v-timeline-item>
                  </v-timeline>
                </v-card>
                <v-card class="pa-4 elevation-0" width="400">
                  <v-timeline dense>
                    <v-timeline-item small fill-dot color="grey" icon-color="grey lighten-2">
                      <template>
                        <v-btn text color="deep-purple accent-4">Outline</v-btn>
                      </template>
                      <v-card class="elevation-2" height="130">
                        <v-card-text v-if="text1.length > 100">
                          {{ text.substring(0, 100) }} . .
                          .
                          <br />
                          <a color="blue">click to read more</a>
                        </v-card-text>
                        <v-card-text v-else>
                          {{
                          text1
                          }}
                        </v-card-text>
                      </v-card>
                    </v-timeline-item>
                  </v-timeline>
                </v-card>
                <v-card class="pa-4 elevation-0" width="400">
                  <v-timeline dense>
                    <v-timeline-item small fill-dot color="grey" icon-color="grey lighten-2">
                      <template>
                        <template>
                          <v-btn text color="deep-purple accent-4">Expected Outcome</v-btn>
                        </template>
                      </template>
                      <v-card class="elevation-2" height="130">
                        <v-card-text v-if="text.length > 100">
                          {{ text.substring(0, 100) }} . .
                          .
                          <br />
                          <a color="blue">click to read more</a>
                        </v-card-text>
                        <v-card-text v-else>
                          {{
                          text
                          }}
                        </v-card-text>
                      </v-card>
                    </v-timeline-item>
                  </v-timeline>
                </v-card>
              </v-card-text>
              <v-fade-transition>
                <v-overlay v-if="hover" absolute color="#036358">
                  <v-btn @click="dialog = !dialog">See more info</v-btn>
                </v-overlay>
              </v-fade-transition>
            </v-card>
          </template>
        </v-hover>
      </v-flex>
      <v-flex xs12 sm12 md12 lg12 x12>
        <v-card flat class="ma-2">
          <v-row>
            <v-col cols="auto" class="mr-auto">
              <v-card class="pa-2 elevation-0" tile>
                <v-btn text color="deep-purple accent-4">Course Modules</v-btn>
              </v-card>
            </v-col>
            <v-col cols="auto">
              <v-card class="pa-2 elevation-0" tile>
                <v-btn small rounded color="success" dark @click="takeExam = !takeExam">Take Exam</v-btn>
              </v-card>
            </v-col>
          </v-row>
          <v-expansion-panels>
            <v-expansion-panel v-for="(module, index) in course.modules" :key="module.id">
              <v-expansion-panel-header>
                <strong>
                  {{ index + 1 }} &nbsp;{{
                  module.title
                  }}
                </strong>
                <template v-slot:actions>
                  <v-icon color="primary">$expand</v-icon>
                </template>
              </v-expansion-panel-header>
              <v-expansion-panel-content color="grey lighten-3">
                <v-card-title v-text="course.description">
                    {{
                    course.description
                    }}
                  </v-card-title>
                <v-spacer></v-spacer>
                <v-btn @click="readModule(module)" class="float-right" outlined color="info">
                  Read
                  <v-icon>arrow_forward</v-icon>
                </v-btn>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-card>
      </v-flex>
      <v-flex xs12 sm5 md3 lg3 xl3>
        <!-- course detail model -->
        <v-row>
          <v-dialog v-model="dialog" halfscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
              <v-card-title class="headline grey lighten-2 fixed" primary-title fixed>
                <span>{{ course.title }}</span>
                <v-spacer></v-spacer>
                <v-menu bottom left>
                  <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                      <v-icon @click="dialog = !dialog">mdi-close-box</v-icon>
                    </v-btn>
                  </template>
                </v-menu>
              </v-card-title>
              <v-card-text>
                <v-row>
                  <v-col s="12" class="mx-6">
                    <v-window
                      v-model="window"
                      class="elevation-0"
                      :vertical="vertical"
                      :show-arrows="showArrows"
                      :reverse="reverse"
                    >
                      <v-window-item>
                        <v-card flat>
                          <v-card-text>
                            <v-row class="mb-4" align="center">
                              <v-btn icon>
                                <v-icon small>description</v-icon>
                              </v-btn>
                              <strong class="title">Description</strong>
                            </v-row>
                            <p>{{ course.description }}</p>
                            <p>
                              Lorem ipsum dolor sit
                              amet, consectetur
                              adipiscing elit, sed do
                              eiusmod tempor
                              incididunt ut labore et
                              dolore magna aliqua. Ut
                              enim ad minim veniam,
                              quis nostrud
                              exercitation ullamco
                              laboris nisi ut aliquip
                              ex ea commodo consequat.
                              Duis aute irure dolor in
                              reprehenderit in
                              voluptate velit esse
                              cillum dolore eu fugiat
                              nulla pariatur.
                              Excepteur sint occaecat
                              cupidatat non proident,
                              sunt in culpa qui
                              officia deserunt mollit
                              anim id est laborum.
                            </p>
                          </v-card-text>
                          <v-divider></v-divider>
                        </v-card>
                        <v-card flat>
                          <v-card-text>
                            <v-row class="mb-4" align="center">
                              <v-btn icon>
                                <v-icon small>offline_pin</v-icon>
                              </v-btn>
                              <strong class="title">Outcome</strong>
                            </v-row>
                            <p>
                              Lorem ipsum dolor sit
                              amet, consectetur
                              adipiscing elit, sed do
                              eiusmod tempor
                              incididunt ut labore et
                              dolore magna aliqua. Ut
                              enim ad minim veniam,
                              quis nostrud
                              exercitation ullamco
                              laboris nisi ut aliquip
                              ex ea commodo consequat.
                              Duis aute irure dolor in
                              reprehenderit in
                              voluptate velit esse
                              cillum dolore eu fugiat
                              nulla pariatur.
                              Excepteur sint occaecat
                              cupidatat non proident,
                              sunt in culpa qui
                              officia deserunt mollit
                              anim id est laborum.
                            </p>
                            <p>
                              Lorem ipsum dolor sit
                              amet, consectetur
                              adipiscing elit, sed do
                              eiusmod tempor
                              incididunt ut labore et
                              dolore magna aliqua. Ut
                              enim ad minim veniam,
                              quis nostrud
                              exercitation ullamco
                              laboris nisi ut aliquip
                              ex ea commodo consequat.
                              Duis aute irure dolor in
                              reprehenderit in
                              voluptate velit esse
                              cillum dolore eu fugiat
                              nulla pariatur.
                              Excepteur sint occaecat
                              cupidatat non proident,
                              sunt in culpa qui
                              officia deserunt mollit
                              anim id est laborum.
                            </p>
                          </v-card-text>
                          <v-divider></v-divider>
                        </v-card>
                        <v-card flat>
                          <v-card-text>
                            <v-row class="mb-4" align="center">
                              <v-btn icon>
                                <v-icon small>waves</v-icon>
                              </v-btn>
                              <strong class="title">Outline</strong>
                            </v-row>
                            <p>
                              Lorem ipsum dolor sit
                              amet, consectetur
                              adipiscing elit, sed do
                              eiusmod tempor
                              incididunt ut labore et
                              dolore magna aliqua. Ut
                              enim ad minim veniam,
                              quis nostrud
                              exercitation ullamco
                              laboris nisi ut aliquip
                              ex ea commodo consequat.
                              Duis aute irure dolor in
                              reprehenderit in
                              voluptate velit esse
                              cillum dolore eu fugiat
                              nulla pariatur.
                              Excepteur sint occaecat
                              cupidatat non proident,
                              sunt in culpa qui
                              officia deserunt mollit
                              anim id est laborum.
                            </p>
                          </v-card-text>
                        </v-card>
                      </v-window-item>
                      <v-window-item>
                        <v-container fluid>
                          <v-row dense>
                            <v-col cols="flex 6">
                              <v-card class="ma-6 pa-12 elevation-5">
                                <div>
                                  Course Details
                                  Summary
                                </div>
                                <v-list-item title="Instructor">
                                  <v-list-item-avatar>
                                    <v-img src="/images/avatar.png"></v-img>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>Instructor</v-list-item-subtitle>
                                    <v-list-item-title>
                                      John
                                      Doe Doe
                                      Doe
                                      Doe
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">timer</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>Duration</v-list-item-subtitle>
                                    <v-list-item-title>
                                      Expected
                                      to last
                                      {{
                                      course.duration
                                      }}
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">room_service</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>
                                      Course
                                      Weight
                                    </v-list-item-subtitle>
                                    <v-list-item-title>
                                      {{
                                      course.weight
                                      }}
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">
                                      fas
                                      fa-list
                                    </v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>
                                      Numbers
                                      Enrolled
                                    </v-list-item-subtitle>
                                    <v-list-item-title>
                                      {{
                                      course.numEnrolled
                                      }}
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                              </v-card>
                            </v-col>
                            <v-col cols="flex 6">
                              <v-card class="ma-6 pa-12 elevation-5">
                                <div>
                                  Enrollment
                                  History
                                </div>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">timer</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>
                                      Enrolled
                                      On
                                    </v-list-item-subtitle>
                                    <v-list-item-title>
                                      February
                                      20,
                                      2020
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">timer</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>
                                      First
                                      Exam
                                      Attended
                                    </v-list-item-subtitle>
                                    <v-list-item-title>
                                      February
                                      23,
                                      2020
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">autorenew</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>
                                      Number
                                      of Exams
                                      Taken
                                    </v-list-item-subtitle>
                                    <v-list-item-title>4</v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                  <v-list-item-avatar>
                                    <v-icon color="grey lighten-1">info</v-icon>
                                  </v-list-item-avatar>
                                  <v-list-item-content>
                                    <v-list-item-subtitle>Status</v-list-item-subtitle>
                                    <v-list-item-title>Pass/Failed/Retaking/In-Progress</v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-window-item>
                    </v-window>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text right @click="dialog = false">Close</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
        <!-- end course detail model -->
        <!-- start of exam confirmation -->
        <div class="text-center">
          <v-dialog persistent v-model="takeExam" width="500">
            <v-card>
              <v-card-title class="title grey lighten-2">Confirm</v-card-title>
              <v-card-text class="subtitle">
                    <br />
                    Are you sure you want to Complete the
                    <b>Exam</b> now?
                </v-card-text>

              <v-divider></v-divider>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" outlined @click="takeExam = !takeExam">Cancel</v-btn>
                <v-btn color="primary" @click="goToExamPage(course)">Continue</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </div>
        <!-- end of exam confirmation -->
        <!-- module study model -->
          <app-main-modal
            v-if="!!module"
            :is-open.sync="isModuleOpen"
            color="blue-grey darken-1"
            @close-modal="closeModule"
            :title="module.title"
          >
            <v-layout row wrap>
              <v-flex sm3>
                <v-card class="elevation-0">
                  <v-card-text>
                    <v-list nav two-line dark class="blue-grey darken-1">
                      <v-list-item
                        @click="setActiveTopic(null)"
                        v-bind:class="{grey: !activeTopic}"
                      >
                        <v-list-item-action>
                          <v-icon>mdi-star</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title>Overview</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-list-item
                        v-for="topic in module.topics"
                        :key="topic.id"
                        @click="setActiveTopic(topic)"
                        v-bind:class="{grey: activeTopic && activeTopic.id == topic.id}"
                      >
                        <v-list-item-action>
                          <v-icon>mdi-star</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title>{{topic.title}}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex sm9>
                <v-template>
                  <v-window
                    v-model="window"
                    class="elevation-1 ma-2 mt-4 mr-6"
                    :vertical="vertical"
                    :show-arrows="showNoArrows"
                    :reverse="reverse"
                    scrolly
                  >
                    <v-window-item v-if="!!activeTopic">
                      <v-card>
                        <v-card-text>
                          <v-row class="mb-4" align="center">
                            <v-avatar color="grey" class="mr-4"></v-avatar>
                            <strong class="title">{{activeTopic.title}}</strong>
                            <v-spacer></v-spacer>
                          </v-row>
                          <v-card-title>Description</v-card-title>
                          <p>{{activeTopic.description}}
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                          </p>
                          <v-card-title>Content</v-card-title>
                          <div v-html="activeTopic.body"></div>
                        </v-card-text>
                      </v-card>
                    </v-window-item>
                    <v-window-item v-else>
                      <v-card>
                        <v-card-text>
                          <v-row class="mb-4" align="center">
                          <v-card-title >Overview</v-card-title>
                            <p>{{ course.description }}</p>
                            <p>
                              <v-card-subtitle > <v-btn icon>
                                <v-icon small>description</v-icon>
                              </v-btn>Description</v-card-subtitle>
                              Lorem ipsum dolor sit
                              amet, consectetur
                              adipiscing elit, sed do
                              eiusmod tempor
                              incididunt ut labore et
                              dolore magna aliqua. Ut
                              enim ad minim veniam,
                              quis nostrud
                              exercitation ullamco
                              laboris nisi ut aliquip
                              ex ea commodo consequat.
                              Duis aute irure dolor in
                              reprehenderit in
                              voluptate velit esse
                              cillum dolore eu fugiat
                              nulla pariatur.
                              Excepteur sint occaecat
                              cupidatat non proident,
                              sunt in culpa qui
                              officia deserunt mollit
                              anim id est laborum.
                            </p>
                          </v-row>
                  </v-card-text>
                      </v-card>
                    </v-window-item>
                  </v-window>
                </v-template>
              </v-flex>
            </v-layout>
          </app-main-modal>
        <!-- </v-template> -->
        <!-- end module study model -->
      </v-flex>
    </template>
    <template v-else>
      <h1>Course not found!</h1>
    </template>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";
import { baseUrl, EventBus } from "../../app";

export default {
  created() {},
  mounted() {},
  computed: {
    ...mapGetters({
      courses: "COURSES",
      course: "ACTIVE_COURSE",
      module: "ACTIVE_MODULE",
      isLoading: "LOADING"
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
      if (!newValue && !this.$store.state.activeCourse) {
        let slug = this.$route.params.slug;
        console.log(slug);
        let course = this.courses.find(c => c.slug === slug);
        if (course) {
          this.$store.dispatch("SET_ACTIVE_COURSE", course);
        } else {
          this.$router.push({ name: "courses" });
        }
      }
    }
  },
  data() {
    return {
      dialog: false,
      isModuleOpen: false,
      activeTopic: null,
      takeExam: false,
      window: 0,
      showArrows: true,
      showNoArrows: false,
      vertical: false,
      reverse: false,
      autorun: false,
      overlay: false,
      colors: [
        "indigo",
        "pink darken-4",
        "red darken-5",
        "deep-purple accent-4"
      ],
      model: 0,
      text:
        "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Why do we use itIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)",
      text1: "'lorem ipsum (injected humour and the like)"
    };
  },
  beforeRouteLeave(to, from, next) {
    next();
  },

  methods: {
    goToExamPage() {
      this.takeExam = false;
      let url = baseUrl + "/exam/" + this.course.slug;
      let win = window.open(url);
      win.focus();
    },
    readModule(module) {
      this.$store.dispatch("SET_ACTIVE_MODULE", module);
      // this.$store.dispatch("SET_ACTIVE_WINDOW", "module");
      // this.$router.push({
      //     name: "study",
      //     params: { slug: this.course.slug, moduleId: module.id }
      // });
      this.isModuleOpen = true;
    },
    closeModule() {
      this.isModuleOpen = false;
      this.$store.dispatch("SET_ACTIVE_MODULE", null);
    },
    setActiveTopic(topic) {
      this.activeTopic = topic;
    }
  },
  created() {
    setInterval(() => {
      if (!this.autorun) return;
      if (++this.window >= this.length) this.window = 0;
    }, 1000);
  }
};
</script>

<style scoped></style>
