<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading"/>
        <template v-else>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <button type="button" class="btn btn-outline-dark btn-block" @click="editRole()">
                        <i class="nav-icon fas fa-plus"></i>
                        Add Role
                    </button>
                    <ul class="list-group mt-2">
                        <li class="list-group-item" v-for="role in roles"
                            :key="role.id"
                            @click="viewRole(role)"
                            v-bind:class="{active: activeRole && activeRole.id === role.id}">
                            {{role.name}}
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6">
                    <template v-if="!!activeRole">
                        <div class="card my-2">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{activeRole.name}} Permissions
                                </h4>
                                <button type="button"
                                        class="btn btn-primary btn-sm float-right"
                                        @click="editRole(activeRole)">
                                    Edit
                                </button>
                            </div>
                            <div class="card-body">
                                <template v-for="permission in permissions">
                                    <div class="row">
                                        <div class="col-1">
                                            <input
                                                type="checkbox"
                                                v-model="activeRole.permissions[permission.slug]"
                                                class="custom-checkbox"
                                                @click="toggleChildren(permission)"
                                            >
                                        </div>
                                        <div class="col-11">
                                            {{permission.name}}
                                        </div>
                                    </div>
                                    <template v-for="child in permission.children">
                                        <div class="row">
                                            <div class="offset-1 col-1">
                                                <input
                                                    type="checkbox"
                                                    v-model="activeRole.permissions[child.slug]"
                                                    :data-parent="child.parentId"
                                                    class="custom-checkbox"
                                                >
                                            </div>
                                            <div class="col-10">{{child.name}}</div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                            <div class="card-footer">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm float-right"
                                    @click="updatePermissions()"
                                    :disabled="$isEqual(oldPermissions, activeRole.permissions)">
                                    Update
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <RoleForm/>
        </template>
    </div><!-- /.container-fluid -->
</template>

<script>
    import {mapGetters} from "vuex";
    import Spinner from "../../Shared/Spinner";
    import RoleForm from "./RoleForm";
    import {deepClone} from "../../../utils/helpers";

    export default {
        props: {title: String},
        created() {
            this.getRoles();
        },
        data() {
            return {
                activeRole: null,
                oldPermissions: null,
                isLoading: false,
            }
        },
        components: {RoleForm, Spinner},
        computed: {
            ...mapGetters({
                roles: "ROLES",
                permissions: "PERMISSIONS",
            }),
        },
        methods: {
            async getRoles() {
                try {
                    this.isLoading = true;
                    await this.$store.dispatch('GET_ROLES');
                    this.isLoading = false;
                    if (!!this.activeRole) {
                        this.oldPermissions = deepClone(this.activeRole.permissions);
                    }
                } catch (error) {
                    console.error(error);
                    this.isLoading = false;
                }
            },
            viewRole(role) {
                this.activeRole = role;
                this.oldPermissions = deepClone(role.permissions);
            },
            editRole(role = null) {
                EventBus.$emit("EDIT_ROLE", role);
            },
            toggleChildren(permission) {
                for (let child of permission.children) {
                    this.activeRole.permissions[child.slug] = !this.activeRole.permissions[permission.slug];
                }
            },
            async updatePermissions() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("UPDATE_PERMISSIONS", this.activeRole);
                    this.getRoles();
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    this.isSending = false;
                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                    this.isSending = false;
                }
            },

            async deleteRole(role) {
                try {

                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                    this.isSending = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
