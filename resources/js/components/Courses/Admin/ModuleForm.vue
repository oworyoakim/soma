<template>
    <v-dialog persistent v-model="isOpen" max-width="800px">
        <v-card>
            <v-card-title>
                <span v-if="topic.id" class="headline">Edit Module</span>
                <span v-else class="headline">Add Module</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="module.title" label="Name*" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <label>Description</label>
                            <app-rich-text-editor
                                v-model="topic.description"
                                :value="topic.description"
                                placeholder="Enter a description of what the question tests."
                            />
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="primary" outlined dark class="mb-2" @click="closeForm">Cancel</v-btn>
                <v-btn :disabled="isSending || !topic.title.trim()" color="primary" dark class="mb-2" @click="saveTopic">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {EventBus} from "../../../app";
    import Topic from "../../../models/Topic";

    export default {
        props: {
            moduleId: Number,
        },
        created() {
            EventBus.$on(["ADD_TOPIC", "EDIT_TOPIC"], this.openForm);
        },
        data() {
            return {
                topic: new Topic(),
                isOpen: false,
                isSending: false,
            }
        },
        methods: {
            async saveTopic() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_TOPIC", this.topic);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: response});
                    this.closeForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR",{text: error,context: 'error'});
                }
            },
            openForm(topic = null) {
                if (!!topic) {
                    this.topic = topic;
                } else {
                    this.topic = new Topic();
                    this.topic.moduleId = this.moduleId;
                }
                this.isOpen = true;
            },
            closeForm() {
                this.topic = new Topic();
                this.topic.moduleId = this.moduleId;
                this.isOpen = false;
            }
        }
    }
</script>

<style scoped>

</style>
