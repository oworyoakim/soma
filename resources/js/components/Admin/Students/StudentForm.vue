<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off">
                <div class="form-group row">
                    <label class="col-sm-3" for="firstName">First Name*</label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="student.firstName"
                               id="firstName"
                               class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="lastName">Last Name*</label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="student.lastName"
                               id="lastName"
                               class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="lastName">Registration Number*</label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="student.enrollNumber"
                               id="enrollNumber"
                               class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="email">Email Address</label>
                    <div class="col-sm-9">
                        <input type="email"
                               v-model="student.email"
                               id="email"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" for="username">Username*</label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="student.username"
                               id="username"
                               class="form-control"
                               required>
                    </div>
                </div>
                <template v-if="!student.id">
                    <div class="form-group row">
                        <label class="col-sm-3" for="password">Password*</label>
                        <div class="col-sm-9">
                            <input type="password"
                                   v-model="student.password"
                                   id="password"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="cpassword">Confirm Password*</label>
                        <div class="col-sm-9">
                            <input type="password"
                                   v-model="student.cpassword"
                                   id="cpassword"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                </template>
            </form>
        </template>
        <template slot="footer">
            <button type="button" class="btn btn-info btn-block" :disabled="formInvalid"
                    @click="saveStudent()">
                <template v-if="isSending">
                    <Spinner/>
                </template>
                <template v-else>
                    <i class="fas fa-save"></i>
                    Save
                </template>
            </button>
        </template>
    </MainModal>
</template>

<script>
import MainModal from "../../Shared/MainModal";
import User from "../../../models/User";
import {deepClone} from "../../../utils/helpers";

export default {
    components: {
        MainModal,
    },
    created() {
        EventBus.$on('EDIT_STUDENT', this.editStudent);
    },
    computed: {
        title() {
            return (!!this.student.id) ? "Edit Student" : "New Student";
        },
        formInvalid() {
            let passwordValid = !!this.student.id ||
                (!!this.student.password && this.student.password === this.student.cpassword);
            return this.isSending || !(
                !!this.student.firstName &&
                !!this.student.lastName &&
                !!this.student.username &&
                passwordValid
            );
        },
    },
    data() {
        return {
            student: new User(),
            isEditing: false,
            isSending: false,
        }
    },
    methods: {
        editStudent(student = null) {
            if (student) {
                this.student = deepClone(student);
            } else {
                this.student = new User();
            }
            this.isEditing = true;
        },
        async saveStudent() {
            try {
                this.isSending = true;
                let response = await this.$store.dispatch("SAVE_STUDENT", this.student);
                this.isSending = false;
                await this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit('STUDENT_SAVED');
                this.resetForm();
            } catch (error) {
                this.isSending = false;
                await this.$store.dispatch('SWEET_ALERT', {context: 'error', message: error});
            }
        },
        resetForm() {
            this.isEditing = false;
            this.student = new User();
        },
    }
}
</script>

<style scoped>

</style>
