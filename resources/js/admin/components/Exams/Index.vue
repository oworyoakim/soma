<template>
    <div class="container-fluid  pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else>
            <ExamsList :title="title"/>
        </template>
        <ExamForm/>
        <PreviewExam />
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ExamsList from "./ExamsList";
import ExamForm from "./ExamForm";
import PreviewExam from "./PreviewExam";

export default {
    props: ['title'],
    components: {PreviewExam, ExamsList, ExamForm},
    created() {

    },
    mounted() {
        this.getExams().then(() => {
            this.$store.dispatch("GET_FORM_SELECTIONS_OPTIONS", {
                options: "courses",
            });
        });
    },
    computed: {
        ...mapGetters({
            isLoading: "LOADING",
        }),
    },
    methods: {
        getExams() {
            return this.$store.dispatch("GET_EXAMS");
        }
    }
}
</script>

<style scoped>

</style>
