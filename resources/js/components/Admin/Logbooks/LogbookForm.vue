<template>
    <MainModal v-if="isEditing" @closed="resetForm()" @submitted="saveLogbook()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <div class="form-group row">
                <label class="col-sm-4">Instructor</label>
                <div class="col-sm-8">
                    <select v-model="logbook.instructorId" class="form-control" required>
                        <option>Select...</option>
                        <option v-for="instructor in instructors" :value="instructor.id">
                            {{ instructor.fullName }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Flight Type</label>
                <div class="col-sm-8">
                    <select v-model="logbook.flightTypeId" class="form-control" required>
                        <option>Select...</option>
                        <option v-for="flightType in flightTypes" :value="flightType.id">
                            {{ flightType.title }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Aircraft</label>
                <div class="col-sm-8">
                    <input type="text" v-model="logbook.aircraft" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Registration</label>
                <div class="col-sm-8">
                    <input type="text" v-model="logbook.registration" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Route</label>
                <div class="col-sm-8">
                    <input type="text" v-model="logbook.route" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Date</label>
                <div class="col-sm-8">
                    <DateRangePicker
                        :config="$store.getters.singleDatePickerConfig"
                        v-model="logbook.dateRecorded"
                        :value="logbook.dateRecorded"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Start Time</label>
                <div class="col-sm-8">
                    <input type="time" v-model="logbook.startTime" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">End Time</label>
                <div class="col-sm-8">
                    <input type="time" v-model="logbook.endTime" class="form-control" required>
                </div>
            </div>
        </template>
        <template slot="footer">
            <button type="submit"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import MainModal from "../../Shared/MainModal";
import Logbook from "../../../models/Logbook";
import {mapGetters} from "vuex";
import DateRangePicker from "../../Shared/DateRangePicker";

export default {
    components: {DateRangePicker, MainModal},
    created() {
        EventBus.$on('EDIT_LOGBOOK', this.editLogbook);
    },
    data() {
        return {
            logbook: new Logbook(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            formSelections: 'FORM_SELECTIONS_OPTIONS',
        }),
        instructors() {
            return this.formSelections.instructors;
        },
        flightTypes() {
            return this.formSelections.flightTypes;
        },
        title() {
            return (this.logbook.id) ? "Edit Flight" : "Add Flight";
        },
        datesAreValid(){
            let startDateTime = null;
            let endDateTime = null;
            if(this.logbook.dateRecorded && this.logbook.startTime) {
                startDateTime = `${this.logbook.dateRecorded} ${this.logbook.startTime}`;
            }
            if(this.logbook.dateRecorded && this.logbook.endTime){
                endDateTime = `${this.logbook.dateRecorded} ${this.logbook.endTime}`;
            }
            return !!startDateTime && !!endDateTime && this.$moment(endDateTime).isAfter(startDateTime);
        },
        formInvalid() {
            return this.isSending || !(
                !!this.logbook.aircraft ||
                !!this.logbook.route ||
                !!this.logbook.registration ||
                this.datesAreValid
            );
        },
    },
    methods: {
        editLogbook(logbook = null) {
            if (logbook) {
                this.logbook = this.deepClone(logbook);
            } else {
                this.logbook = new Logbook();
            }
            this.isEditing = true;
        },
        async saveLogbook() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch('SAVE_LOGBOOK', this.logbook);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.logbook = new Logbook();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
