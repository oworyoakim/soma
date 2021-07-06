<template>
    <div class="module-details mt-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title  text-bold">{{title}}</h3>
                <div class="card-tools">
                    <template v-if="isEditingDescription">
                        <button @click="editModuleDescription(false)"
                                type="button"
                                class="btn btn-dark btn-sm mr-2">
                            Cancel
                        </button>
                        <button type="button"
                                @click="updateDescription()"
                                :disabled="isSending || moduleDescription === module.description"
                                class="btn btn-primary btn-sm">
                            Save
                        </button>
                    </template>
                    <template v-else>
                        <button @click="backToModules()" class="btn btn-dark btn-sm mr-5">
                            <i class="fa fa-backward"></i>
                            Back To Modules
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
            <div class="card-body">
                <template v-if="isEditingDescription">
                    <div class="form-group">
                        <TinymceEditor
                            v-model="moduleDescription"
                            :api-key="$store.getters.TINYMCE_API_KEY"
                            :init="{...$store.getters.EDITOR_CONFIG,height: 600}"
                        />
                    </div>
                </template>
                <template v-else>
                    <div class="row">
                        <div class="col-md-12" v-html="module.description"></div>
                    </div>
                </template>
            </div>
        </div>
        <ModuleForm :course-id="courseId" :course-title="courseTitle"/>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ModuleForm from "./ModuleForm";
import TopicForm from "../Topics/TopicForm";
import {deepClone} from "../../../shared/utils/helpers";

export default {
    props: {
        courseId: {
            type: String | Number,
            required: true,
            default: null
        },
        courseTitle: String,
    },
    components: {
        TopicForm,
        ModuleForm,
        TinymceEditor: require('@tinymce/tinymce-vue').default,
    },
    computed: {
        ...mapGetters({
            module: "ACTIVE_MODULE",
        }),
        title() {
            if (!this.module) {
                return '';
            }
            if (this.module.course) {
                return this.module.course.title + " / " + this.module.title;
            } else if (this.courseTitle) {
                return this.courseTitle + " / " + this.module.title;
            }
            return this.module.title;
        },
    },
    data() {
        return {
            moduleDescription: null,
            isEditingDescription: false,
            isSending: false,
        }
    },
    created() {
        EventBus.$on(["MODULE_SAVED"], () => {
            this.$store.dispatch("GET_MODULE_DETAILS", {moduleId: this.module.id});
        });
    },
    methods: {
        backToModules() {
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
