<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group">
                    <label>Student</label>
                    <select class="form-control"
                            v-model="enrollment.studentId"
                            required>
                        <option value="">Select...</option>
                        <option v-for="student in students" :value="student.id">
                            {{ student.fullName }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Program</label>
                    <select class="form-control"
                            v-model="enrollment.programId"
                            required>
                        <option value="">Select...</option>
                        <option v-for="program in programs" :value="program.id">
                            {{ program.title }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Intake</label>
                    <select class="form-control"
                            v-model="enrollment.intakeId"
                            required>
                        <option value="">Select...</option>
                        <option v-for="intake in intakes" :value="intake.id">
                            {{ intake.title }}
                        </option>
                    </select>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveEnrollment()"
                    type="submit"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import {mapGetters} from "vuex";
import Enrollment from "../../../models/Enrollment";
import MainModal from "../../Shared/MainModal";

export default {
    components: {MainModal},
    created() {
        EventBus.$on("EDIT_ENROLLMENT", this.editEnrollment);
    },
    data() {
        return {
            enrollment: new Enrollment(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            selectionsOptions: 'FORM_SELECTIONS_OPTIONS',
        }),
        intakes() {
            return this.selectionsOptions.intakes;
        },
        programs() {
            return this.selectionsOptions.programs;
        },
        students() {
            return this.selectionsOptions.students;
        },

        title() {
            return (this.enrollment.id) ? "Edit Enrollment" : "New Enrollment";
        },
        formInvalid() {
            return this.isSending;
        }
    },
    methods: {
        editEnrollment(enrollment = null) {
            if (enrollment) {
                this.enrollment = this.deepClone(enrollment);
            } else {
                this.enrollment = new Enrollment();
            }
            this.isEditing = true;
        },
        async saveEnrollment() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_ENROLLMENT", this.enrollment);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                this.resetForm();
                EventBus.$emit("ENROLLMENT_SAVED");
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.enrollment = new Enrollment();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
