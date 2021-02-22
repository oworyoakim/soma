<template>
    <div class="module-details mt-2">
        <div class="row mt-2">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" @click="editModuleDescription(false)" href="#module_description"
                           data-toggle="tab">
                            Description
                        </a>
                    </li>
                    <li class="nav-item" v-if="$store.getters.HAS_ANY_ACCESS(['topics','topics.view','topics.create','topics.update'])">
                        <a class="nav-link" @click="editModuleDescription(false)" href="#module_topics"
                           data-toggle="tab">
                            Topics
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2">
                    <div class="tab-pane active" id="module_description">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title  text-bold">
                                    {{course.title}} - {{module.title}}
                                </h3>
                                <div class="card-tools">
                                    <template v-if="isEditingDescription">
                                        <button @click="editModuleDescription(false)" type="button"
                                                class="btn btn-dark btn-sm mr-2">Cancel
                                        </button>
                                        <button type="button" @click="updateDescription()"
                                                :disabled="isSending || moduleDescription === module.description"
                                                class="btn btn-primary btn-sm">Save
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click="backToCourse()" class="btn btn-dark btn-sm mr-5">
                                            <i class="fa fa-backward"></i>
                                            Back To Course
                                        </button>
                                        <button v-if="$store.getters.HAS_ANY_ACCESS(['modules.update'])"
                                                @click="editModuleDescription()"
                                                :disabled="isEditingDescription"
                                                class="btn btn-info btn-sm float-right">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div v-if="isEditingDescription" class="card-body">
                                <div class="form-group">
                                    <TinymceEditor
                                        v-model="moduleDescription"
                                        :api-key="$store.getters.TINYMCE_API_KEY"
                                        :init="{...$store.getters.EDITOR_CONFIG,height: 600}"
                                    />
                                </div>
                            </div>
                            <div v-else class="card-body" v-html="module.description">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="module_topics">
                        <ModuleTopics/>
                        <ModuleForm/>
                        <TopicForm/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ModuleTopics from "../Topics/ModuleTopics";
    import ModuleForm from "./ModuleForm";
    import {mapGetters} from "vuex";
    import TopicForm from "../Topics/TopicForm";
    import {deepClone} from "../../../utils/helpers";

    export default {
        created() {
            EventBus.$on(["MODULE_SAVED","TOPIC_SAVED"], () => {
                this.$store.dispatch("GET_MODULE_DETAILS", {moduleId: this.module.id});
            });
        },
        components: {
            TopicForm,
            ModuleForm,
            ModuleTopics,
            TinymceEditor: require('@tinymce/tinymce-vue').default,
        },
        computed: {
            ...mapGetters({
                course: "ACTIVE_COURSE",
                module: "ACTIVE_MODULE",
            }),
        },
        data() {
            return {
                moduleDescription: null,
                isEditingDescription: false,
                isSending: false,
            }
        },
        methods: {
            backToCourse() {
                this.editModuleDescription(false);
                this.$store.dispatch("SET_ACTIVE_MODULE", null);
            },
            editModuleDescription(editing = true) {
                if (editing) {
                    this.moduleDescription = this.module.description;
                    this.isEditingDescription = true;
                } else {
                    this.isEditingDescription = false;
                    this.moduleDescription = null;
                }
            },
            async updateDescription() {
                try {
                    let module = {
                        id: this.module.id,
                        description: this.moduleDescription,
                    };
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_MODULE", module);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    let newModule = deepClone(this.module);
                    newModule.description = module.description;
                    this.$store.commit("SET_ACTIVE_MODULE", newModule);
                    this.editModuleDescription(false);
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            }
        },
    }
</script>

<style scoped>
    .module-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
