<template>
    <v-flex class="justify-center">
        <v-card class="align-center text-center">
            <v-card-title class="mb-2">
                <h1>{{ examInfo.courseTitle }}</h1>
            </v-card-title>
            <v-card-text v-html="instructions"></v-card-text>
            <v-card-actions>
                <v-btn
                    class="ma-2"
                    width="150px"
                    tile
                    color="green"
                    @click="nextToStart"
                    dark
                >Start</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters({
            examInfo: "EXAM_INFO"
        }),
        instructions() {
            return this.examInfo.instructions;
        }
    },

    methods: {
        nextToStart() {
            this.$store.dispatch("SET_EXAM_STATUS", "inprogress");
            // this.$router.push({
            //     name: 'exam-details',
            //     params: {questionId: 1}
            // });
        }
    }
};
</script>
