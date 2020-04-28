<template>
    <router-view></router-view>
</template>
<script>
import {mapGetters} from "vuex";
export default {
    created() {
        this.$store.dispatch("GET_COURSES",{});
    },
  computed: {

  },
  methods: {
    viewCourse(course) {
      this.$store.dispatch("SET_ACTIVE_COURSE", course);
      this.$nextTick(() => {
        this.$router.push({
          name: "admin-course-details",
          params: { slug: course.slug }
        });
      });
    },
  }
};
</script>

<style scoped>
</style>
