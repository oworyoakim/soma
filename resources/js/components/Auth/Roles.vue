<template>
    <v-layout child-flex row wrap>
        <v-progress-circular
            v-if="isLoading"
            class="justify-center"
            :size="50"
            color="primary"
            indeterminate
        ></v-progress-circular>
        <template v-else>
            <v-container class="row wrap">
                <v-flex sm6 md4 lg3 xl3>
                    <v-subheader class="justify-center ma-2">
                        <v-btn color="primary" block dark @click="editRole()">
                            <v-icon dark>mdi-plus</v-icon>
                            Add Role
                        </v-btn>
                    </v-subheader>
                    <v-card class="ml-2">
                        <v-card-text>
                            <v-row v-for="role in roles" :key="role.id"
                                   v-bind:class="{grey: activeRole && activeRole.id == role.id}">
                                <v-col class="xs10 mr-2">
                                    <v-list-item-title @click="viewRole(role)" style="cursor: pointer;"
                                                       v-text="role.name"></v-list-item-title>
                                </v-col>
                                <v-col class="xs2 text-right">
                                    <v-btn right icon @click="editRole(role)">
                                        <v-icon right>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn right icon @click="deleteRole(role)">
                                        <v-icon right>mdi-delete</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex sm6 md8 lg9 xl9>
                    <template v-if="!!activeRole.id">
                        <v-card class="ma-2">
                            <v-card-title>{{activeRole.name}} Permissions</v-card-title>
                            <v-card-text>
                                <v-treeview
                                    v-model="activeRole.permissions"
                                    :items="permissions"
                                    selectable
                                    item-key="slug"
                                ></v-treeview>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="updatePermissions()">Update</v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                </v-flex>
            </v-container>
            <v-dialog v-model="editingRole" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span v-if="!!activeRole.id" class="headline">Edit Role</span>
                        <span v-else class="headline">New Role</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="activeRole.name" label="Name*" required></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" outlined @click="closeRoleModal()">Cancel</v-btn>
                        <v-btn :disabled="!activeRole.name.trim()" color="primary" @click="saveRole()">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </v-layout>
</template>

<script>

    import {mapGetters} from "vuex";
    import Role from "../../models/Role";

    export default {
        created() {
            this.getRoles();
        },
        computed: {
            ...mapGetters({
                roles: "ROLES",
                permissions: "PERMISSIONS",
            }),
        },
        data() {
            return {
                headers: [
                    {text: 'Name', value: 'name', sortable: false},
                    {text: 'Actions'},
                ],
                activeRole: new Role(),
                editingRole: false,
                isLoading: false,
                isSending: false,
            }
        },
        methods: {
            async getRoles() {
                try {
                    this.isLoading = true;
                    await this.$store.dispatch('GET_ROLES');
                    this.isLoading = false;
                } catch (error) {
                    console.error(error);
                }
            },
            editRole(role = null) {
                if (role) {
                    this.activeRole = role;
                } else {
                    this.activeRole = new Role();
                }
                this.editingRole = true;
            },
            viewRole(role) {
                this.activeRole = role;
            },
            closeRoleModal() {
                this.activeRole = new Role();
                this.editingRole = false;
            },
            async saveRole() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("SAVE_ROLE", this.activeRole);
                    this.closeRoleModal();
                    this.getRoles();
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    this.isSending = false;
                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                    this.isSending = false;
                }
            },
            async updatePermissions() {
                try {
                    this.isSending = true;
                    let response = await this.$store.dispatch("UPDATE_PERMISSIONS", this.activeRole);
                    this.getRoles();
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    this.isSending = false;
                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                    this.isSending = false;
                }
            },

            async deleteRole(role) {
                try {

                } catch (error) {
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                    this.isSending = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
