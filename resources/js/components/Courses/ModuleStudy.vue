<template>
  <v-layout row wrap v-if="activeTopic">
      <v-card class="mx-auto my-auto"  width="1000" height="600" outlined>
          <v-card-text>
          <h1>{{activeTopic.title}}</h1>
              <div v-html="activeTopic.body">
              </div>
              </v-card-text>
      </v-card>
  </v-layout>
  <v-layout row wrap v-else>
    <h1>Overview</h1>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";
import { EventBus } from "../../app";

export default {
  created() {
    EventBus.$on("TOPIC", topic => {
      this.activeTopic = topic;
    });
  },
  mounted() {
    if (!this.$store.state.activeCourse) {
      let slug = this.$route.params.slug;
      console.log(slug);
      let course = this.courses.find(c => c.slug === slug);
      if (course) {
        this.$store.dispatch("SET_ACTIVE_COURSE", course);
        let moduleId = this.$route.params.moduleId;
        let module = course.modules.find(m => m.id == moduleId);
        if (module) {
          this.$store.dispatch("SET_ACTIVE_MODULE", module);
          this.$store.dispatch("SET_ACTIVE_WINDOW", "module");
        } else {
          this.$router.push({
            name: "course-details",
            params: { slug: course.slug }
          });
        }
      } else {
        this.$router.push({ name: "courses" });
      }
    }
  },
  beforeRouteLeave(to, from, next) {
    //this.$store.dispatch('SET_ACTIVE_COURSE', null);
    next();
  },
  computed: {
    ...mapGetters({
      courses: "COURSES",
      course: "ACTIVE_COURSE",
      module: "ACTIVE_MODULE"
    })
  },
  data() {
    return {
      activeTopic: null
    };
  },
  methods: {}
};
</script>

<style scoped>
</style>
