<template>
    <!-- Login Tab Content -->
    <div class="login-right">
        <div class="login-header text-center">
            <p class="small">
                <a href="/" class="navbar-brand logo">
                    <img src="/images/logo.png" class="img-fluid img-rounded" height="50">
                </a>
            </p>
            <p class="mt-2">Sign in to continue</p>
        </div>
        <form @submit.prevent="login()" autocomplete="off">
            <div class="form-group">
                <label class="form-control-label">Email Address</label>
                <input type="email"
                       v-model="credentials.loginName"
                       class="form-control"
                       autofocus
                       :readonly="isSending">
            </div>
            <div class="form-group">
                <label class="form-control-label">Password</label>
                <div class="pass-group">
                    <input :type="showingPlainPassword ? 'text': 'password'"
                           v-model="credentials.loginPassword"
                           class="form-control pass-input"
                           :readonly="isSending">
                    <span class="fas toggle-password"
                          :class="showingPlainPassword ? 'fa-eye-slash': 'fa-eye'"
                          @click="togglePassword()">
                    </span>
                </div>
            </div>
            <div class="text-right">
                <a v-if="!isSending" class="forgot-link" href="/forgot-password">
                    Forgot Password?
                </a>
            </div>
            <button type="submit" class="btn btn-primary login-btn" :disabled="formInvalid">
                <Spinner v-if="isSending"/>
                <template v-else>Login</template>
            </button>
            <div v-if="!isSending" class="text-center dont-have">
                Don’t have an account? <a href="/signup">Register</a>
            </div>
        </form>
    </div>
    <!-- /Login Tab Content -->
</template>

<script>
import Spinner from "../../../shared/components/Spinner";

export default {
    components: {Spinner},
    data() {
        return {
            isSending: false,
            showingPlainPassword: false,
            credentials: {
                loginName: '',
                loginPassword: '',
            }
        }
    },
    computed: {
        formInvalid() {
            return this.isSending;
        },
    },
    methods: {
        async login() {
            this.isSending = true;
        },
        togglePassword() {
            this.showingPlainPassword = !this.showingPlainPassword;
        },
    },
}
</script>

<style scoped>

</style>
