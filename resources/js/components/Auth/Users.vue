<template>
    <v-layout child-flex>
        <v-progress-circular
            v-if="isLoading"
            class="justify-center"
            :size="50"
            color="primary"
            indeterminate
        ></v-progress-circular>
        <template v-else>
            <v-row>
                <v-col cols="12" class="sm12 ml-2">
                    <v-data-table
                        :headers="headers"
                        :items="users"
                        item-key="id"
                        class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>Users</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-dialog persistent v-model="editingUser" max-width="800px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn @click="editUser()" color="primary" dark class="mb-2" v-on="on">New
                                            User
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline" v-if="!!activeUser.id">Edit User</span>
                                            <span class="headline" v-else>New User</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container grid-list-lg>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="First Name*"
                                                            v-model="activeUser.firstName"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="Last Name*"
                                                            v-model="activeUser.lastName"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="Email Address"
                                                            v-model="activeUser.email"
                                                            type="email"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-select
                                                            :items="roles"
                                                            label="Role*"
                                                            item-text="name"
                                                            item-value="id"
                                                            v-model="activeUser.roleId"
                                                        ></v-select>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="Username*"
                                                            v-model="activeUser.username"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="Password*"
                                                            type="password"
                                                            v-model="activeUser.password"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            label="Confirm Password*"
                                                            type="password"
                                                            v-model="activeUser.cpassword"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary" outlined @click="closeUserModal()">Cancel</v-btn>
                                            <v-btn color="primary" :disabled="!userFormValid || isSending"
                                                   @click="saveUser()">Save
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>

                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="editUser(item)">edit</v-icon>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </template>
    </v-layout>
</template>

<script>
    import User from "../../models/User";
    import {mapGetters} from "vuex";

    export default {
        created() {
            this.getUsers();
        },
        mounted() {
            console.log('Roles', this.roles);
        },
        data() {
            return {
                headers: [
                    {text: 'First Name', value: 'firstName', sortable: false},
                    {text: 'Last Name', value: 'lastName', sortable: true},
                    {text: 'Email', value: 'email', sortable: false},
                    {text: 'Username', value: 'username', sortable: true},
                    {text: 'Role', value: 'role.name', sortable: true},
                    {text: 'Actions'},
                ],
                activeUser: new User(),
                editingUser: false,
                isLoading: false,
                isSending: false,
            }
        },
        computed: {
            ...mapGetters({
                users: "USERS",
                roles: "ROLES",
                permissions: "PERMISSIONS",
            }),
            userFormValid() {
                if (!this.activeUser.firstName.trim()) {
                    return false;
                }
                if (!this.activeUser.lastName.trim()) {
                    return false;
                }

                if (!this.activeUser.email.trim()) {
                    return false;
                }

                if (!this.activeUser.username.trim()) {
                    return false;
                }

                if (!this.activeUser.roleId) {
                    return false;
                }
                if (!this.activeUser.password || this.activeUser.password !== this.activeUser.cpassword) {
                    return false;
                }
                return true;
            }
        },
        methods: {
            async getUsers() {
                try {
                    this.isLoading = true;
                    await this.$store.dispatch('GET_USERS');
                    this.isLoading = false;
                } catch (error) {
                    console.error(error);
                    this.isLoading = false;
                }
            },
            editUser(user = null) {
                if (user) {
                    this.activeUser = user;
                }
                this.editingUser = true;
            },

            closeUserModal() {
                this.activeUser = new User();
                this.editingUser = false;
            },
            async saveUser() {
                try {
                    let response = await this.$store.dispatch("SAVE_USER", this.activeUser);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    this.getUsers();
                    this.closeUserModal();
                } catch (error) {
                    console.error(error);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {text: error, context: 'error'});
                }
            },
        }
    }
</script>

<style scoped>

</style>
