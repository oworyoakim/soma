<template>
    <div class="container-fluid pt-2">
        <div class="card mx-auto">
            <div class="card-header border-0">
                <div class="card-title">
                    <h3><a href="javascript:void(0)">{{ activeProgram.title }}</a></h3>
                </div>
                <div class="card-tools text-right">
                    <button @click="backToProgram()" type="button" class="btn btn-secondary btn-sm mr-2">
                        <i class="fa fa-backward"></i> Back To Programs
                    </button>
                    <button @click="editProgram()" type="button" class="btn btn-info btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" v-html="activeProgram.description"></div>
                </div>
                <div class="row">
                    <div class="col-md-12" v-html="activeProgram.requirements"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            activeProgram: "ACTIVE_PROGRAM",
            courses: "COURSES",
        }),
    },
    methods: {
        backToProgram() {
            this.$store.commit("SET_ACTIVE_PROGRAM", null);
        },
        editProgram(){
            EventBus.$emit("EDIT_PROGRAM", this.activeProgram);
        }
    }
}
</script>

<style scoped>

</style>
