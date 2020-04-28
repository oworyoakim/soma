<template>
    <v-app id="inspire">
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>Account Login</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-alert dense outlined text v-if="loginError" type="error">{{loginError}}</v-alert>
                                <v-form>
                                    <v-text-field
                                        label="Username"
                                        v-model="form.loginName"
                                        type="text"
                                        prepend-icon="account_circle"
                                    ></v-text-field>
                                    <v-text-field
                                        :type="showPassword ? 'text' : 'password'"
                                        label="Password"
                                        v-model="form.password"
                                        prepend-icon="lock"
                                        :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                                        @click:append="showPassword = !showPassword"
                                        @keyup.enter="login()"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" block @click="login()" :disabled="isSending || !(form.loginName && form.password)">
                                    <v-progress-circular v-if="isSending" indeterminate/>
                                    <v-list-item-action-text v-else>Login</v-list-item-action-text>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
        <app-toast/>
    </v-app>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        data() {
            return {
                showPassword: false,
                isSending: false,
                form: new Form({
                    loginName: '',
                    password: ''
                }),
                loginError: '',
            };
        },
        methods: {
            async login() {
                try {
                    if (!this.form.loginName || !this.form.password) {
                        return;
                    }
                    this.isSending = true;
                    let response = await this.$store.dispatch('LOGIN', {
                        login_name: this.form.loginName,
                        password: this.form.password,
                    });
                    this.isSending = false;
                    //console.log(response);
                    this.$store.dispatch("SET_SNACKBAR", {text: response});
                    setTimeout(() => {
                        location.reload();
                    },500);
                } catch (error) {
                    this.isSending = false;
                    console.log(error);
                    this.loginError = error;
                }
            }
        }
    }
</script>

<style scoped>

</style>
