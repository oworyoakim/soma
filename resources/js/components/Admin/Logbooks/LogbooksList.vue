<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ title }}</h3>
            <div class="card-tools">
                <button @click="editLogbook()" class="btn btn-dark btn-sm">
                    <i class="fas fa-plus"></i> Add Flight
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-condensed table-sm">
                <thead class="text-uppercase">
                <tr>
                    <th><i class="fa fa-calendar text-warning"></i>&nbsp;Date</th>
                    <th><i class="fa fa-plane text-warning"></i>&nbsp;Aircraft</th>
                    <th><i class="fa fa-edit text-warning"></i>&nbsp;Registration</th>
                    <th><i class="fa fa-map-marker text-warning"></i>&nbsp;Route</th>
                    <th><i class="fa fa-clock text-warning"></i>&nbsp;Time</th>
                    <th><i class="fa fa-clock text-warning"></i>&nbsp;Flight Time</th>
                    <th><i class="fa fa-plane-arrival text-warning"></i>&nbsp;Landings</th>
                    <th><i class="fa fa-cog text-warning"></i>&nbsp;Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="logbook in logbooks">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-info mr-2" @click="viewLogbook(logbook)">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-info mr-2" @click="editLogbook(logbook)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" @click="deleteLogbook(logbook)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props: ['title'],
    data(){
        return {

        }
    },
    computed: {
        ...mapGetters({
            logbooks: "LOGBOOKS",
        }),
    },
    methods: {
        viewLogbook(logbook = null) {
            this.$store.commit("SET_ACTIVE_LOGBOOK", logbook);
        },
        editLogbook(logbook = null) {
            EventBus.$emit("EDIT_LOGBOOK", logbook);
        },
        deleteLogbook(logbook) {

        },
        approveLogbook(logbook) {

        },

        declineLogbook(logbook) {

        },
    },
}
</script>

<style scoped>

</style>
