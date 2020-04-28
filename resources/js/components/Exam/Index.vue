<template>
    <v-progress-circular  v-if="isLoading" color="primary"></v-progress-circular>
    <v-layout row wrap v-else>
        <app-exam-instructions v-if="examStatus === 'pending'"/>
        <app-exam-session v-else-if="examStatus === 'inprogress'"/>
        <app-exam-results v-else/>
    </v-layout>
</template>

<script>
import {mapGetters} from "vuex";
    export default {
        props:{
            slug: {
                type: String,
                required: true,
            }
        },
        created(){
            //this.getExamInfo();
        },
        computed:{
            ...mapGetters({
                examInfo: 'EXAM_INFO',
                examStatus: 'EXAM_STATUS',
            }),
        },
        data(){
            return {
                isLoading: false,
            }
        },
        methods:{
            async getExamInfo() {
                try {
                    this.isLoading = true;
                    let response = await this.$store.dispatch("GET_EXAM_INFO",this.slug);
                    this.isLoading = false;
                } catch (error) {
                    console.error(error);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>