<template>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <div class="alert alert-warning alert-dismissible" v-if="loginError">
                <button type="button" @click="loginError = ''" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                {{loginError}}
            </div>
            <div class="alert alert-danger alert-dismissible" v-if="!!errorMessage">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{errorMessage}}
            </div>
            <form @submit.prevent="login()" method="post">
                <div class="input-group mb-3">
                    <input v-model="form.loginName" type="text" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input v-model="form.password" type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button :disabled="formInvalid" type="submit" class="btn btn-primary btn-block">
                            <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                            <span v-else>Login</span>
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        props: {
            errorMessage: ''
        },
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
        computed: {
            formInvalid() {
                return this.isSending || !(this.form.loginName && this.form.password);
            }
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
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    setTimeout(() => {
                        location.reload();
                    }, 500);
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
