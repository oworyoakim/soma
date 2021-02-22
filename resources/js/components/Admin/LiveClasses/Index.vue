<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else-if="classroom">
            <!--  Classroom details -->
            <ClassroomDetails />
        </template>
        <template v-else>
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{title}}</h3>
                    <div class="card-tools">
                        <button @click="editClassroom()"
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-card-widget="add"
                                title="Schedule New Live Classroom">
                            <i class="fas fa-plus"></i>
                            Schedule Class
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <ClassroomsList/>
                </div>
            </div>
            <ClassroomForm />
        </template>
        <FullscreenModal v-if="isPreviewing && classroomForPreview" @closed="closePreview()">
            <template slot="header">{{classroomForPreview.title}}</template>
            <template slot="body">
                <ZoomFrame :classroom-id="classroomForPreview.id" />
            </template>
        </FullscreenModal>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ClassroomsList from "./ClassroomsList";
import ClassroomForm from "./ClassroomForm";
import ClassroomDetails from "./ClassroomDetails";
import FullscreenModal from "../../Shared/FullscreenModal";
import ZoomFrame from "../../Shared/ZoomFrame";

export default {
    props: {title: String},
    components: {
        ZoomFrame,
        FullscreenModal,
        ClassroomsList,
        ClassroomForm,
        ClassroomDetails,
    },
    created() {
        this.getClassrooms();
        EventBus.$on("PREVIEW_CLASSROOM", this.previewClassroom);
    },
    data(){
        return {
            classroomForPreview: null,
            isPreviewing: false,
            filters: {
                courseId: null,
                moduleId: null,
                topicId: null,
                instructorId: null,
                status: null,
            }
        }
    },
    computed: {
        ...mapGetters({
            classroom: "ACTIVE_CLASSROOM",
            isLoading: "LOADING"
        }),
    },
    methods: {
        editClassroom(classroom = null){
            EventBus.$emit("EDIT_CLASSROOM", classroom);
        },
        getClassrooms(){
            return this.$store.dispatch("GET_CLASSROOMS",this.filters);
        },
        previewClassroom(classroom){
            this.classroomForPreview = classroom;
            this.isPreviewing = true;
        },
        closePreview(){
            this.classroomForPreview = null;
            this.isPreviewing = false;
        },
    },
}
</script>

<style scoped>

</style>
