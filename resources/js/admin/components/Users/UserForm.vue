<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">First Name</label>
                    <div class="col-md-9">
                        <input v-model="user.firstName"
                               class="form-control"
                               type="text"
                               placeholder="First name"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Last Name</label>
                    <div class="col-md-9">
                        <input v-model="user.lastName"
                               class="form-control"
                               type="text"
                               placeholder="Last name"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Email</label>
                    <div class="col-md-9">
                        <input v-model="user.email"
                               class="form-control"
                               type="email"
                               placeholder="Email address"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Role</label>
                    <div class="col-md-9">
                        <select v-model="user.roleId" class="form-control" required>
                            <option value="">Select...</option>
                            <option v-for="role in roles" :value="role.id" :key="role.id">
                                {{ role.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Username</label>
                    <div class="col-md-9">
                        <input v-model="user.username"
                               class="form-control"
                               type="text"
                               placeholder="Username"
                               autocomplete="off"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Password</label>
                    <div class="col-md-9">
                        <input v-model="user.password"
                               class="form-control"
                               type="password"
                               placeholder="****"
                               autocomplete="off"
                               :required="!user.id">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Confirm Password</label>
                    <div class="col-md-9">
                        <input v-model="user.cpassword"
                               class="form-control"
                               type="password"
                               placeholder="****"
                               autocomplete="off"
                               :required="!user.id">
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveUser()"
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
import MainModal from "../../../shared/components/MainModal";
import {deepClone} from "../../../shared/utils/helpers";
import {User} from "../../../models/User";

export default {
    components: {MainModal},
    created() {
        EventBus.$on('EDIT_USER', this.editUser);
    },
    data() {
        return {
            user: new User(),
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        ...mapGetters({
            roles: "ROLES",
            permissions: "PERMISSIONS",
        }),
        title() {
            return (!!this.user.id) ? "Edit User" : "New User";
        },
        passwordsValid(){
            // password is required and must match cpassword when we are creating a new user
            let validForInsert = !this.user.id && !!this.user.password && this.user.password === this.user.cpassword;
            // when updating user,
            // 1. both password and cpassword can be empty
            // 2. otherwise both must match
            let validForUpdate = !!this.user.id && ((!this.user.password && !this.user.cpassword) || (!!this.user.password && this.user.password === this.user.cpassword));
            return validForInsert || validForUpdate;
        },
        formInvalid() {
            return this.isSending || !(!!this.user.firstName &&
                !!this.user.lastName &&
                !!this.user.username &&
                !!this.user.roleId &&
                this.passwordsValid
            );
        }
    },
    methods: {
        editUser(user = null) {
            if (user) {
                this.user = deepClone(user);
            } else {
                this.user = new User();
            }
            this.isEditing = true;
        },
        async saveUser() {
            try {
                let response = await this.$store.dispatch("SAVE_USER", this.user);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: response});
                EventBus.$emit("USER_SAVED");
                this.resetForm();
            } catch (error) {
                console.error(error);
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.user = new User();
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
