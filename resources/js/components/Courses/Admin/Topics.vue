<template>
    <v-card flat>
        <v-card-title class="headline">
            Topics
            <v-spacer/>
            <v-btn color="primary" dark class="mb-2" @click="editTopic()">Add Topic</v-btn>
        </v-card-title>
        <v-expansion-panels>
            <v-expansion-panel v-for="(topic,index) in topics" :key="topic.id">
                <v-expansion-panel-header>Topic {{index+1}}</v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-card flat>
                        <v-card-title>{{topic.title}}</v-card-title>
                        <v-card-text v-html="topic.description"/>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
        <app-topic-form :module-id="moduleId"/>
    </v-card>
</template>

<script>
    import {EventBus} from "../../../app";

    export default {
        props:{
            topics: {
                type: Array,
                required: true,
                default: () => []
            },
            moduleId: Number,
        },
        methods: {
            editTopic(topic = null){
                EventBus.$emit("EDIT_TOPIC", topic);
            }
        }
    }
</script>

<style scoped>

</style>
