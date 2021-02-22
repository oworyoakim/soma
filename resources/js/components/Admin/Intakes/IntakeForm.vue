<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Name</label>
                    <div class="col-md-9">
                        <input v-model="intake.title"
                               class="form-control"
                               type="text"
                               placeholder="Level name"
                               required>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="save()"
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
import MainModal from "../../Shared/MainModal";
import Intake from "../../../models/Intake";
import {deepClone} from "../../../utils/helpers";

export default {
    components: {MainModal},
    created() {
        EventBus.$on('EDIT_INTAKE', this.editIntake);
    },
    data() {
        return {
            intake: new Intake(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        title() {
            return (!!this.intake.id) ? "Edit Intake" : "New Intake";
        },
        formInvalid() {
            return this.isSending  || !(!!this.intake.title);
        }
    },
    methods: {
        editIntake(intake = null) {
            if (intake) {
                this.intake = deepClone(intake);
            } else {
                this.intake = new Intake();
            }
            this.isEditing = true;
        },
        async save() {
            try {
                let response = await this.$store.dispatch("SAVE_INTAKE", this.intake);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("INTAKE_SAVED");
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.intake = new Intake();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
