<template>
    <table class="table table-condensed table-sm">
        <thead>
        <tr>
            <th>Title</th>
            <th class="text-center">Questions</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="topic in topics">
            <td>{{topic.title}}</td>
            <td class="text-center">{{topic.numQuestions}}</td>
            <td>
                <button class="btn btn-sm btn-info mr-2" @click="viewTopic(topic)">
                    <i class="fa fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-info mr-2" @click="editTopic(topic)">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" @click="deleteTopic(topic)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                topics: "TOPICS",
            }),

        },
        methods:{
            viewTopic(topic){
                this.$store.dispatch("GET_TOPIC_DETAILS", {topicId: topic.id});
            },
            editTopic(topic = null){
                EventBus.$emit("EDIT_TOPIC", topic);
            },
            async deleteTopic(topic){

            }
        },
    }
</script>

<style scoped>

</style>
