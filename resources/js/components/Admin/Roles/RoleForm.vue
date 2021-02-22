<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Role Name</label>
                    <div class="col-md-9">
                        <input v-model="role.name"
                               class="form-control"
                               type="text"
                               placeholder="Role name"
                               autofocus>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button @click="saveRole()"
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
    import MainModal from "../../Shared/MainModal";
    import {deepClone} from "../../../utils/helpers";
    import Role from "../../../models/Role";

    export default {
        components: {MainModal},
        created() {
            EventBus.$on("EDIT_ROLE", this.editRole);
        },
        data() {
            return {
                isEditing: false,
                isSending: false,
                role: new Role(),
            }
        },
        computed: {
            ...mapGetters({
                roles: "ROLES",
            }),
            title() {
                return (!!this.role.id) ? "Edit Role" : "New Role";
            },
            formInvalid() {
                return this.isSending || !(!!this.role.name);
            }
        },
        methods: {
            editRole(role = null) {
                if (role) {
                    this.role = deepClone(role);
                } else {
                    this.role = new Role();
                }
                this.isEditing = true;
            },
            async saveRole() {
                try {
                    let response = await this.$store.dispatch("SAVE_ROLE", this.role);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    EventBus.$emit("ROLE_SAVED");
                    this.resetForm();
                } catch (error) {
                    console.error(error);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
            resetForm() {
                this.role = new Role();
                this.isEditing = false;
            }
        }
    }
</script>

<style scoped>

</style>
